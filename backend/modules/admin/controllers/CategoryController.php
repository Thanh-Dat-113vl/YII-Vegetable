<?php

namespace backend\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Category;
use yii\web\NotFoundHttpException;
use yii\helpers\Inflector;


class CategoryController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        if ($model->image == null || $model->image == '') {
            $model->image = 'noimage.png';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Thêm danh mục thành công!');
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cập nhật danh mục thành công!');
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa danh mục thành công!');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Không tìm thấy danh mục này.');
    }

    public function actionToggleStatus($id)
    {
        $model = Category::findOne($id);
        if ($model) {
            $model->status = $model->status ? 0 : 1;
            $model->save(false);
        }
        return $this->redirect(['index']);
    }


    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (empty($this->slug) && !empty($this->name)) {
                $this->slug = Inflector::slug($this->name);
            }
            return true;
        }
        return false;
    }
}
