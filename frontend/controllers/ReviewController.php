<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Review;
use common\models\OrderItem;

class ReviewController extends Controller
{
    // public function actionCreate($product_id)
    // {
    //     try {
    //         if (Yii::$app->user->isGuest) {
    //             if (Yii::$app->request->isAjax) {
    //                 Yii::$app->response->format = Response::FORMAT_JSON;
    //                 return ['success' => false, 'message' => 'Bạn cần đăng nhập để đánh giá.'];
    //             }
    //             return $this->redirect(['/site/login']);
    //         }

    //         $userId = Yii::$app->user->id;

    //         $model = new Review();
    //         $model->user_id = $userId;
    //         $model->product_id = $product_id;

    //         $request = Yii::$app->request;
    //         if ($model->load($request->post())) {
    //             $model->created_at = date('Y-m-d H:i:s');

    //             if ($model->validate()) {
    //                 if ($model->save(false)) {
    //                     if ($request->isAjax) {
    //                         Yii::$app->response->format = Response::FORMAT_JSON;
    //                         return ['success' => true, 'message' => 'Cảm ơn bạn đã đánh giá.'];
    //                     }
    //                     Yii::$app->session->setFlash('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    //                     return $this->redirect(['product/view', 'id' => $product_id]);
    //                 }
    //                 // save failed unexpectedly
    //                 $errors = $model->getErrors();
    //                 Yii::error('Review save failed: ' . json_encode($errors), __METHOD__);
    //                 if ($request->isAjax) {
    //                     Yii::$app->response->format = Response::FORMAT_JSON;
    //                     return ['success' => false, 'message' => 'Lưu đánh giá thất bại.', 'errors' => $errors];
    //                 }
    //                 Yii::$app->session->setFlash('error', 'Gửi đánh giá thất bại.');
    //                 return $this->redirect(['product/view', 'id' => $product_id]);
    //             }

    //             // validation errors
    //             $errors = $model->getErrors();
    //             Yii::info('Review validation errors: ' . json_encode($errors), __METHOD__);
    //             if ($request->isAjax) {
    //                 Yii::$app->response->format = Response::FORMAT_JSON;
    //                 return ['success' => false, 'message' => 'Dữ liệu không hợp lệ.', 'errors' => $errors];
    //             }
    //             Yii::$app->session->setFlash('error', implode('; ', array_map(fn($a) => implode(',', $a), $errors)));
    //             return $this->redirect(['product/view', 'id' => $product_id]);
    //         }

    //         // no POST
    //         throw new \BadMethodCallException('Invalid request method');
    //     } catch (\Throwable $e) {
    //         Yii::error($e->getMessage() . "\n" . $e->getTraceAsString(), __METHOD__);
    //         if (Yii::$app->request->isAjax) {
    //             Yii::$app->response->format = Response::FORMAT_JSON;

    //             return ['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()];
    //         }
    //         Yii::$app->session->setFlash('error', 'Lỗi server khi gửi đánh giá.');
    //         return $this->redirect(['product/view', 'id' => $product_id]);
    //     }
    // }

    public function actionCreate($product_id)
    {
        try {
            if (Yii::$app->user->isGuest) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => false, 'message' => 'Bạn cần đăng nhập để đánh giá.'];
                }
                return $this->redirect(['/site/login']);
            }


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new Review();

            if ($model->load(Yii::$app->request->post())) {
                $model->product_id = $product_id;
                $model->created_at = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return ['success' => true];
                }
                return ['success' => false, 'error' => $model->errors];
            }

            return ['success' => false, 'msg' => 'Dữ liệu không hợp lệ'];
        } catch (\Exception $e) {
            return $this->redirect(['product/view', 'id' => $product_id]);
        };
    }
}
