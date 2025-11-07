<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Transaction;
use common\models\Product;
use common\models\Orders;
use common\models\OrderItem;
use yii\web\Response;
use yii\helpers\Url;

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
        return $this->redirect(['site/index']);
    }


    public function actionCheckout()
    {
        $cookies = Yii::$app->request->cookies;
        $cart = [];

        $user = Yii::$app->user->isGuest ? null : Yii::$app->user->identity;

        if ($cookies->has('cart')) {
            $cart = json_decode($cookies->getValue('cart'), true);
        }

        if (empty($cart)) {
            Yii::$app->session->setFlash('error', 'Giỏ hàng trống!');
            return $this->redirect(['site/cart']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Tạo đơn hàng
            $order = new Orders();
            $order->user_id = $user ? $user->id : null;
            $order->order_code = 'ORD' . time();
            // $order->name = $user ? $user->username : 'Khách';
            // $order->phone = Yii::$app->request->post('phone');
            $order->payment_method = Yii::$app->request->post('payment');
            $order->status = 'pending';
            $order->payment_method = Yii::$app->request->post('payment');
            $totalPrice = 0;
            $order->created_at = date('Y-m-d H:i:s');
            $order->updated_at = date('Y-m-d H:i:s');
            $order->payment_method = Yii::$app->request->post('payment');


            // 🔹 Kiểm tra loại giao hàng
            $deliveryType = Yii::$app->request->post('delivery_type');
            if ($deliveryType === 'store') {
                $order->delivery_type = 'store';
                $order->shipping_address = null;
                $order->store_name = Yii::$app->request->post('store_name');
                $order->phone = $user ? $user->phone : Yii::$app->request->post('phone');
                $shipping_fee = 0;
            } else {
                $order->delivery_type = 'delivery';
                $order->shipping_address = Yii::$app->request->post('address');
                $order->phone = $user ? $user->phone : Yii::$app->request->post('phone');
                $shipping_fee = 15000;
            }
            $order->save();
            $total = 0;

            // Tạo các mục đơn hàng
            foreach ($cart as $item) {

                $product = Product::findOne($item['id']);
                if (!$product) {
                    throw new \RuntimeException("Sản phẩm #{$item['id']} không tồn tại.");
                }

                $qty = (int)$item['quantity'];
                if ($qty <= 0) {
                    continue;
                }

                // Kiểm tra tồn kho (nếu có)
                if (isset($product->stock) && $product->stock !== null && $product->stock < $qty) {
                    throw new \RuntimeException("Sản phẩm {$product->name} chỉ còn {$product->stock} trong kho.");
                }

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['id'];
                $orderItem->name = $item['name'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->save(false);

                if (isset($product->stock) && $product->stock !== null) {
                    // Cập nhật lại tồn kho
                    $product->stock = max(0, $product->stock - $qty);
                    Yii::$app->db->createCommand("
                        UPDATE product
                        SET stock = GREATEST(stock - :qty, 0)
                        WHERE id = :id
                    ")->bindValues([':qty' => $qty, ':id' => $product->id])->execute();
                }


                $total += $item['price'] * $item['quantity'];
            }
            $order->total_price = $total + $shipping_fee;
            $order->save(false);

            // 🔹 Xóa giỏ hàng trong cookie
            Yii::$app->response->cookies->remove('cart');

            // 🔹 Commit giao dịch
            $transaction->commit();

            Yii::$app->session->setFlash('success', "Đặt hàng thành công! Mã đơn hàng: {$order->order_code}");
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'order_code' => $order->order_code,
                    'redirect' => Url::to(['cart/success', 'id' => $order->id]),
                ];
            }
            // non-AJAX: render trang success
            return $this->render('success', ['order' => $order]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Đặt hàng thất bại: ' . $e->getMessage());
            return $this->redirect(['cart/index']);
        }
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
