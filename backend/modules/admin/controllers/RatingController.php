<?php

namespace backend\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Review;

class RatingController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Review::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {


        $model = Review::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Đánh giá không tồn tại.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Review::findOne($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Đánh giá đã được xóa thành công.');
        } else {
            Yii::$app->session->setFlash('error', 'Đánh giá không tồn tại.');
        }

        return $this->redirect(['index']);
    }
    public function actionApprove($id)
    {
        $model = Review::findOne($id);
        if ($model) {
            $model->status = 1; // Set status to approved
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Đánh giá đã được duyệt thành công.');
        } else {
            Yii::$app->session->setFlash('error', 'Đánh giá không tồn tại.');
        }

        return $this->redirect(['index']);
    }
}
