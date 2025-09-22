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
            // send all mails to a file by default.
            // 'useFileTransport' => true,
            // You have to set
            //
            'useFileTransport' => false,
            //
            // and configure a transport for the mailer to send real emails.
            //
            // SMTP server example:
            'transport' => [
                'class' => 'Swift_SmtpTransport',

                'scheme' => 'smtps',
                'host' => 'smtp.gmail.com',
                'username' => 'caothanhdat113vl@gmail.com',
                'password' => 'xfux xbkz faki qfcd',
                'port' => 587,
                'encryption' => 'tls',
                // 'dsn' => 'native://default',
            ],
            //
            // DSN example:
            //    'transport' => [
            //        'dsn' => 'smtp://user:pass@smtp.example.com:25',
            //    ],
            //
            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];
