<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
            'allow' => true,
            'roles' => ['@'], // chỉ user đã login
            'matchCallback' => function ($rule, $action) {
                return in_array(\Yii::$app->user->identity->role,[0, 1]);
             }
         ],
     ],
    ],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-common',
            'cookieValidationKey' => 'your-key', // Đảm bảo giống frontend
            'csrfCookie' => [
                'httpOnly' => true,
                'domain' => '.localhost', // hoặc domain thật của bạn
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-common',
                'httpOnly' => true,
                'domain' => '.localhost', // hoặc domain thật của bạn
            ],
        ],
        'session' => [
            'name' => 'advanced-common',
            'cookieParams' => [
                'httpOnly' => true,
                'domain' => '.localhost', // hoặc domain thật của bạn
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
