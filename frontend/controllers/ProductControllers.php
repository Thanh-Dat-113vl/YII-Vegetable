<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Product;
use common\models\Review;
use yii\helpers\Html;

class ProductController extends Controller
{
    public function actionIndex()
    {
        $products = Product::find()->all();
        return $this->render('index', compact('products'));
    }

    public function actionView($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException('Sản phẩm không tồn tại.');
        }

        $reviews = Review::find()
            ->where(['product_id' => $product->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        $newReview = new Review();
        $newReview->product_id = $product->id;

        return $this->render('product_detail', [
            'product' => $product,
            'category' => $product->category ?? null,
            'reviews' => $reviews,
            'newReview' => $newReview,
        ]);
    }
    public function actionAddReview($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException("Sản phẩm không tồn tại");
        }

        $model = new Review();
        $model->product_id = $id;
        $user = Yii::$app->user->identity ?? null;
        if ($user) {
            $model->user_id = $user->id;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'success' => true,
                        'review' => [
                            'username' => $user ? Html::encode($user->username) : 'Người dùng',
                            'rating' => (int)$model->rating,
                            'comment' => Html::encode($model->comment),
                            'created_at' => Yii::$app->formatter->asDatetime($model->created_at),
                        ],
                    ];
                }
                Yii::$app->session->setFlash('success', 'Cảm ơn bạn đã gửi đánh giá! Chúng tôi sẽ duyệt sớm.');
                return $this->redirect(['product/view', 'id' => $id]);
            } else {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => false, 'errors' => $model->getErrors()];
                }
            }
        }

        throw new NotFoundHttpException("Trang không tồn tại");
    }
}
