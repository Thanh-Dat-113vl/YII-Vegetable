<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Manage Orders';

$statusList = [
    'pending'   => 'Pending',
    'confirm'   => 'Confirm',
    'shipping'  => 'Shipping',
    'completed' => 'Completed',
    'canceled'  => 'Canceled',
];
?>

<div class="orders-index">
    <h1><?= Html::a($this->title) ?></h1>

    <?= yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'order_code',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return $model->user ? $model->user->username : 'N/A';
                },
            ],
            'phone',
            'shipping_address',
            'store_name',
            'total_price:currency',
            'delivery_type',
            'payment_method',
            'created_at',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {

                    $statusList = [
                        'pending'   => ['Pending',   'background-color:#ffc107; color:#000;'],
                        'confirm'   => ['Confirm',   'background-color:#0d6efd; color:#fff;'],
                        'shipping'  => ['Shipping',  'background-color:#0dcaf0; color:#000;'],
                        'completed' => ['Completed', 'background-color:#198754; color:#fff;'],
                        'canceled'  => ['Canceled',  'background-color:#dc3545; color:#fff;'],
                    ];
                    $items = [];
                    foreach ($statusList as $value => [$label, $style]) {
                        $options[$value] = ['style' => $style];
                        $items[$value] = $label;
                    }


                    foreach ($statusList as $value => [$label, $style]) {
                        $options[$value] = [
                            'style' => $style,
                        ];
                    }

                    return Html::dropDownList(
                        'status',
                        $model->status,
                        $items,
                        [
                            'class' => 'form-control',
                            'style' => $statusList[$model->status][1],
                            'onchange' => "
                                window.location.href = '"
                                . \yii\helpers\Url::to(['change-status', 'id' => $model->id])
                                . "&status=' + this.value;
                            ",
                            'options' => $options,
                        ]
                    );
                }
            ],




            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>