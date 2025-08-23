<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Review;
use common\models\OrderItem;

class ReviewController extends Controller
{
    public function actionCreate($product_id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $userId = Yii::$app->user->id;

        // Kiểm tra xem user đã mua sản phẩm chưa
        $purchased = OrderItem::find()
            ->joinWith('order')
            ->where(['order_item.product_id' => $product_id, 'orders.user_id' => $userId, 'orders.status' => 'completed'])
            ->exists();

        if (!$purchased) {
            Yii::$app->session->setFlash('error', 'Bạn chưa mua sản phẩm này.');
            return $this->redirect(['/product/view', 'id' => $product_id]);
        }

        $model = new Review();
        $model->user_id = $userId;
        $model->product_id = $product_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/product/view', 'id' => $product_id]);
        }

        return $this->render('create', compact('model'));
    }
}
