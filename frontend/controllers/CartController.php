<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
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
        $cart = Yii::$app->session->get('cart', []);
        if (Yii::$app->request->isPost) {
            $order = new Orders();
            $order->user_id = Yii::$app->user->id ?? null;
            $order->total_price = 0;
            $order->payment_method = Yii::$app->request->post('payment');
            $order->shipping_address = Yii::$app->request->post('address');
            $order->save();

            $total = 0;
            foreach ($cart as $id => $qty) {
                $p = Product::findOne($id);
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->product_id = $p->id;
                $item->quantity = $qty;
                $item->price = $p->price;
                $item->save();
                $total += $p->price * $qty;
            }
            $order->total_price = $total;
            $order->save();

            Yii::$app->session->remove('cart');
            return $this->render('success', compact('order'));
        }
        $products = Product::find()->where(['id' => array_keys($cart)])->all();
        return $this->render('checkout', compact('products', 'cart'));
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

    // Giới hạn tồn kho (nếu bạn có trường stock trong Product)
    $product = \common\models\Product::findOne($id);
    $maxStock = $product ? $product->stock : 9999;

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

    $phi = 1;
    // Tính lại tổng tiền
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'] ;
        return ;
    }

    return [
        'success' => true,
        'total' => number_format($total, 0, ',', '.'),
        'subtotal' => isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['quantity'] : 0,
        'quantity' => isset($cart[$id]) ? $cart[$id]['quantity'] : 0,
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
