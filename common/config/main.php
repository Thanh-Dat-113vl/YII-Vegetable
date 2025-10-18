<?php
return [
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'VND',
            'timeZone' => 'Asia/Ho_Chi_Minh',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
        ],
        'user' => [
            ''
        ]
    ],

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@uploads' => 'http://localhost:8081/backend/web/uploads', // URL public

    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];