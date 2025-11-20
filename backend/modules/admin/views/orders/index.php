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

    <form class="row g-3 mb-3" method="get" action="<?= Url::to(['index']) ?>">
        <div class="col-auto">
            <input type="text" name="order_code" value="<?= Html::encode($search) ?>"
                class="form-control form-control-sm"
                placeholder="Tìm theo Mã đơn hàng">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-success">
                <i class="bi bi-search"></i> Tìm kiếm
            </button>
        </div>
    </form>
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
                    $isLocked = in_array($model->status, ['completed', 'canceled']);


                    return Html::dropDownList(
                        'status',
                        $model->status,
                        $items,
                        [
                            'class' => 'form-control',
                            'style' => $statusList[$model->status][1],
                            'disabled' => $isLocked ? true : false,
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
        'tableOptions' => ['class' => 'table table-bordered table-striped'],
        'pager' => [
            'class' => \yii\widgets\LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
            'disabledListItemSubTagOptions' => ['class' => 'page-link disabled'],
        ],
    ]); ?>