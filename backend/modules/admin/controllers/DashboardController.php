<?php

namespace backend\modules\admin\controllers;

use yii\web\Controller;

class DashboardController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
