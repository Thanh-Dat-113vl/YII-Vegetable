<?php

use Soap\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Manager Ratings';
?>
<div class="review-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'product_id',
                'value' => function ($model) {
                    return $model->product ? $model->product->name : 'N/A';
                },
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return $model->user ? $model->user->username : 'N/A';
                },
            ],
            'rating',
            'comment:ntext',
            [
                'attribute' => 'status',
                'format' => 'raw',

                'value' => function ($model) {
                    $url = ['approve', 'id' => $model->id];
                    $btnClass = $model->status ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm';
                    return Html::a(
                        $model->status ? 'Approved' : 'Pending',
                        $url,
                        ['class' => $btnClass]
                    );
                },
            ],


            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>