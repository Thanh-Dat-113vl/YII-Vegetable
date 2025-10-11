<?php

namespace frontend\controllers;

use common\models\Product;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;


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
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $products = \common\models\Product::find()->all();

        return $this->render('index', [
            'products' => $products
        ]);
    }

    public function actionSearch()
    {
        $query = Yii::$app->request->get('query', '');
        $products = [];

        if (!empty($query)) {
            $products = \common\models\Product::find()
                ->where(['like', 'name', $query])
                ->all();
        }

        return $this->render('search', [
            'products' => $products,
            'query' => $query,
        ]);
    }

    public function actionProductDetail($id)
    {
        $product = \common\models\Product::findOne($id);
        $category = \common\models\Category::findOne($product->category_id);

        if (!$product) {
            throw new NotFoundHttpException('Sản phẩm không tồn tại.');
        }

        $related = Product::find()
            ->where(['category_id' => $product->category_id])
            ->andWhere(['<>', 'id', $product->id])
            ->limit(4)
            ->all();

        return $this->render('product_detail', [
            'product' => $product,
            'category' => $category,
            'related' => $related,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            //debug lỗi

            // var_dump($model->getErrors());die;
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                Yii::$app->session->setFlash('success', 'Đăng ký thành công!');
                return $this->goHome();
                // $this->redirect(['site/login'])
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }


    public function actionProduct()
    {
        return $this->render('product');
    }


    // Thêm sản phẩm vào giỏ hàng (qua AJAX)
    public function actionAddToCart()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = json_decode(Yii::$app->request->getRawBody(), true);
        $cookies = Yii::$app->request->cookies;
        $responseCookies = Yii::$app->response->cookies;

        $cart = [];

        if ($cookies->has('cart')) {
            $cart = json_decode($cookies->getValue('cart'), true);
        }


        $id = $data['id'];
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'price' => $data['price'],
                'image' => $data['image'],
                'quantity' => 1
            ];
        }

        // Ghi lại cookie  7 ngày
        $responseCookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => json_encode($cart),
            'expire' => time() + 7 * 24 * 3600
        ]));

        return [
            'success' => true,
            'total' => array_sum(array_column($cart, 'quantity'))
        ];
    }

    public function actionCart()
    {
        $cookies = Yii::$app->request->cookies;
        // $product = \common\models\Product::findOne($id);
        $user = Yii::$app->user->isGuest ? null : Yii::$app->user->identity;
        $cart = [];

        if ($cookies->has('cart')) {
            $cart = json_decode($cookies->getValue('cart'), true);
        }


        return $this->render(
            'cart',
            [
                'cart' => $cart,
                'user' => $user,
            ]
        );
    }
}
