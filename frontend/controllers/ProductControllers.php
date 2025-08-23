<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Product;

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
        return $this->render('view', compact('product'));
    }
}
