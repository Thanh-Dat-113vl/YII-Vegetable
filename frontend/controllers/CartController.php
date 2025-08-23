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
    public function actionRemove($id)
    {
        $cart = Yii::$app->session->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Yii::$app->session->set('cart', $cart);
        }
        return $this->redirect(['index']);
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
}
