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
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                // 'scheme' => 'smtps',
                'host' => 'smtp.gmail.com',
                'username' => 'caothanhdat113vl@gmail.com',
                'password' => 'xfuxxbkzfakiqfcd',
                'port' => 587,
                'encryption' => 'tls',
            ],
            // 'logger' => true,
            //
            // DSN example:
            // 'transport' => [
            //     'dsn' => 'smtps://caothanhdat113vl@gmail.com:xfuxxbkzfakiqfcd@smtp.gmail.com:465',
            // ],

            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];
