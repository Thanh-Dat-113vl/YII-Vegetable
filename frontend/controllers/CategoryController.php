<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Category;

class CategoryController extends Controller
{
    public function actionView($slug)
    {
        $category = Category::find()->where(['slug' => $slug])->one();
        if (!$category) {
            throw new \yii\web\NotFoundHttpException("Không tìm thấy danh mục");
        }

        // Lấy danh sách sản phẩm thuộc category này
        $products = $category->products;

        return $this->render('view', compact('category', 'products'));
    }
}
