<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=127.0.0.1;dbname=QLRC',
            'username' => 'root',
            'password' => 'Aa123456',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtp',
                'host' => 'smtp.gmail.com',
                'username' => 'caothanhdat113vl@gmail.com',
                'password' => 'xfuxxbkzfakiqfcd', // App Password Gmail
                'port' => 587,
                'encryption' => 'tls',
            ],

            //
            // DSN example:
            //     'transport' => [
            //         'smtp://caothanhdat113vl@gmail.com:xfuxxbkzfakiqfcd@smtp.gmail.com:587?encryption=tls',
            //    ],
            //
            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];
