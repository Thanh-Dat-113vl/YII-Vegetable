<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->with('category'),
        ]);
        return $this->render('index', compact('dataProvider'));
    }

    public function actionCreate()
    {
        $model = new Product();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'image');
            if ($file) {
                $path = 'uploads/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($path);
                $model->image = $path;
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'image');
            if ($file) {
                $path = 'uploads/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($path);
                $model->image = $path;
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Không tìm thấy sản phẩm.');
    }
}
