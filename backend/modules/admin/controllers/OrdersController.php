<?php

namespace backend\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Orders;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;


class OrdersController extends Controller
{
    public function actionIndex()
    {
        $search = Yii::$app->request->get('order_code');
        $query = Orders::find();
        if (!empty($search)) {
            $query->andWhere(['like', 'order_code', $search]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => Orders::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);



        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'search' => $search,
        ]);
    }

    public function actionView($id)
    {
        $model = Orders::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Đơn hàng không tồn tại.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
    public function actionToggleStatus($id)
    {
        $model = $this->findModel($id);

        $statuses = ['pending', 'confirm', 'shipping', 'completed', 'canceled'];

        $currentIndex = array_search($model->status, $statuses);

        if ($currentIndex === false) {
            $model->status = 'pending';
        } else {
            $nextIndex = ($currentIndex + 1) % count($statuses);
            $model->status = $statuses[$nextIndex];
        }

        $model->save(false);

        Yii::$app->session->setFlash('success', 'Trạng thái đã được cập nhật');

        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);

        $allowed = ['pending', 'confirm', 'shipping', 'completed', 'canceled'];

        if (!in_array($status, $allowed)) {
            throw new \yii\web\BadRequestHttpException('Invalid status.');
        }

        $model->status = $status;
        $model->save(false);

        return $this->redirect(['index']);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa đơn hàng thành công!');
        return $this->redirect(['index']);
    }
}
