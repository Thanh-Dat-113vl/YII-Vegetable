<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

            'access' => [
            'class' => \yii\filters\AccessControl::class,
            'only' => ['logout', 'index', 'create', 'update', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'], // chỉ cho user đã login
                ],
            ],
        ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        // if (!Yii::$app->user->isGuest) {
        //     return $this->goHome();
        // }

        // $this->layout = 'blank';

        // $model = new LoginForm();
        // if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //     return $this->goBack();
        // }

        // $model->password = '';

        // return $this->render('login', [
        //     'model' => $model,
        // ]);

          // Nếu đã đăng nhập và đúng role thì vào thẳng trang chủ backend
            if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException();
        }

        // Chỉ role 0 và 1 được vào
        $role = Yii::$app->user->identity->role;
        if (!in_array($role, [0, 1])) {
            throw new NotFoundHttpException();
        }

        return parent::beforeAction($action);
    }

    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function beforeAction($action)
{
    if (Yii::$app->user->isGuest) {
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }
    $role = Yii::$app->user->identity->role;

    if (!in_array($role, [0, 1])) {
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }

    return parent::beforeAction($action);

    // if (Yii::$app->user->isGuest || !in_array(Yii::$app->user->identity->role, [0,1])) {
    //     Yii::$app->user->logout();
    //     return $this->redirect('http://localhost:8080'); // về frontend
    // }

    // return true;
}

}
