<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Transaction;
use common\models\Product;
use common\models\Orders;
use common\models\OrderItem;

class CartController extends Controller
{
    public function actionAdd($id)
    {
        $cart = Yii::$app->session->get('cart', []);
        $cart[$id] = isset($cart[$id]) ? $cart[$id] + 1 : 1;
        Yii::$app->session->set('cart', $cart);
        return $this->redirect(['index']);
    }

    public function actionIndex()
    {
        $cart = Yii::$app->session->get('cart', []);
        $products = Product::find()->where(['id' => array_keys($cart)])->all();
        return $this->render('Cart', compact('products', 'cart'));
    }

    public function actionCheckout()
    {
        $request = Yii::$app->request;
        $cookies = Yii::$app->request->cookies;
        $cart = [];

        if ($cookies->has('cart')) {
            $cart = json_decode($cookies->getValue('cart'), true) ?: [];
        } else {
            $sessionCart = Yii::$app->session->get('cart', []);
            if (!empty($sessionCart)) {
                $productIds = array_keys($sessionCart);
                $products = Product::find()->where(['id' => $productIds])->all();
                foreach ($products as $p) {
                    $id = (string)$p->id;
                    $qty = (int)($sessionCart[$id] ?? 0);
                    if ($qty <= 0) continue;
                    $priceSale = $p->price * (100 - ($p->discount ?? 0)) / 100;
                    $cart[$id] = [
                        'id' => $p->id,
                        'name' => $p->name,
                        'price' => (float)$priceSale,
                        'quantity' => $qty,
                        'image' => $p->image ?? '',
                    ];
                }
            }
        }

        if (empty($cart)) {
            Yii::$app->session->setFlash('warning', 'Giỏ hàng trống.');
            return $this->redirect(['site/index']);
        }

        if ($request->isPost) {
            $post = $request->post();
            $paymentMethod = $post['payment'] ?? 'cod';
            $shippingAddress = $post['address'] ?? ($post['shipping_address'] ?? '');
            $shippingFee = (float)($post['shipping_fee'] ?? 0);

            $db = Yii::$app->db;
            $transaction = $db->beginTransaction(Transaction::SERIALIZABLE);
            try {
                $order = new Orders();
                $order->user_id = Yii::$app->user->id ?? null;
                $order->payment_method = $paymentMethod;
                $order->shipping_address = $shippingAddress;
                // $order->shipping_fee = $shippingFee;
                $order->total_price = 0;
                $order->status = Orders::STATUS_PENDING;
                if (!$order->save()) {
                    throw new \RuntimeException('Không thể tạo đơn hàng: ' . json_encode($order->getErrors()));
                }

                $total = 0;
                foreach ($cart as $id => $item) {
                    $product = Product::findOne($item['id']);
                    if (!$product) {
                        throw new \RuntimeException("Sản phẩm #{$item['id']} không tồn tại.");
                    }

                    $qty = (int)$item['quantity'];
                    if ($qty <= 0) continue;

                    if (isset($product->stock) && $product->stock < $qty) {
                        throw new \RuntimeException("Sản phẩm {$product->name} chỉ còn {$product->stock} trong kho.");
                    }

                    $price = (float)$item['price'];
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $product->id;
                    $orderItem->quantity = $qty;
                    $orderItem->price = $price;
                    if (!$orderItem->save()) {
                        throw new \RuntimeException('Không thể lưu item: ' . json_encode($orderItem->getErrors()));
                    }

                    if (isset($product->stock)) {
                        $product->stock = max(0, $product->stock - $qty);
                        $product->save(false);
                    }

                    $total += $price * $qty;
                }

                $order->total_price = $total + $shippingFee;
                $order->save(false);

                $transaction->commit();

                // remove cart cookie/session
                if ($cookies->has('cart')) {
                    Yii::$app->response->cookies->remove('cart');
                }
                Yii::$app->session->remove('cart');

                // send email confirmation if user email exists
                if ($order->user && !empty($order->user->email)) {
                    try {
                        Yii::$app->mailer->compose(
                            ['html' => '@frontend/mail/order-confirm-html', 'text' => '@frontend/mail/order-confirm-text'],
                            ['order' => $order]
                        )
                            ->setTo($order->user->email)
                            ->setFrom([Yii::$app->params['adminEmail'] ?? 'no-reply@example.com' => 'VEGETABLE'])
                            ->setSubject('Xác nhận đơn hàng ' . $order->order_code)
                            ->send();
                    } catch (\Throwable $e) {
                        Yii::error('Mail send error: ' . $e->getMessage(), __METHOD__);
                    }
                }

                Yii::$app->session->setFlash('success', 'Đặt hàng thành công. Mã đơn: ' . $order->order_code);
                return $this->render('success', ['order' => $order]);
            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage(), __METHOD__);
                Yii::$app->session->setFlash('error', 'Lỗi khi tạo đơn hàng: ' . $e->getMessage());
                return $this->redirect(['site/index']);
            }
        }

        // render checkout form
        return $this->render('checkout', ['cart' => $cart]);
    }

    public function actionUpdate()
    {
        $post = Yii::$app->request->post('qty', []);
        $cart = Yii::$app->session->get('cart', []);
        foreach ($post as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id] = max(1, (int)$qty);
            }
        }
        Yii::$app->session->set('cart', $cart);
        return $this->redirect(['index']);
    }



    public function actionUpdateQuantity()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $type = Yii::$app->request->post('type'); // 'plus' hoặc 'minus'

        if (!$id || !$type) {
            return ['success' => false, 'message' => 'Thiếu dữ liệu'];
        }

        $cookies = Yii::$app->request->cookies;
        $cart = [];

        if ($cookies->has('cart')) {
            $cart = json_decode($cookies->getValue('cart'), true);
        }

        if (!isset($cart[$id])) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng'];
        }

        // Giới hạn tồn kho (nếu có)
        $product = Product::findOne($id);
        $maxStock = $product ? ($product->stock ?? 9999) : 9999;

        // Cập nhật số lượng
        if ($type === 'plus' && $cart[$id]['quantity'] < $maxStock) {
            $cart[$id]['quantity'] += 1;
        } elseif ($type === 'minus') {
            $cart[$id]['quantity'] -= 1;
            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]); // Nếu giảm về 0 thì xóa luôn sản phẩm
            }
        }

        // Ghi lại cookie
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => json_encode($cart),
            'expire' => time() + 3600 * 24 * 30
        ]));

        // Tính lại tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $quantity = isset($cart[$id]) ? (int)$cart[$id]['quantity'] : 0;
        $subtotal = isset($cart[$id]) ? ($cart[$id]['price'] * $cart[$id]['quantity']) : 0;

        return [
            'success' => true,
            'total' => number_format($total, 0, ',', '.') . 'đ',
            'subtotal' => number_format($subtotal, 0, ',', '.') . 'đ',
            'quantity' => $quantity,
            'cartCount' => count($cart)
        ];
    }

    public function actionRemoveFromCart()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');

        if (!$id) {
            return ['success' => false, 'message' => 'Thiếu ID sản phẩm'];
        }

        $cookies = Yii::$app->request->cookies;
        $cart = [];

        if ($cookies->has('cart')) {
            $cart = json_decode($cookies->getValue('cart'), true);
        }

        if (!isset($cart[$id])) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng'];
        }

        // Xóa sản phẩm khỏi mảng
        unset($cart[$id]);

        // Cập nhật lại cookie
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => json_encode($cart),
            'expire' => time() + 3600 * 24 * 30
        ]));

        return ['success' => true];
    }
}
