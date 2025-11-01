<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9ykcA8AXHzK2TLWLu8X5ZyemIj349ge5',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                // 'scheme' => 'smtps',
                'host' => 'smtp.gmail.com',
                'username' => 'caothanhdat113vl@gmail.com',
                'password' => 'xfuxxbkzfakiqfcd',
                'port' => 465,
                'encryption' => 'ssl',
                // 'dsn' => 'smtp://caothanhdat113vl@gmail.com:xfuxxbkzfakiqfcd@smtp.gmail.com:587',
            ],
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
    ];
}

return $config;
