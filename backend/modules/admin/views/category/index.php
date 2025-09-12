<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Quản lý Danh mục sản phẩm';
?>
<div class="category-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Thêm Danh mục', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'slug',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $url = ['toggle-status', 'id' => $model->id];
                    $btnClass = $model->status ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm';
                    $label = $model->status ? 'Hiện' : 'Ẩn';
                    return Html::a($label, $url, [
                        'class' => $btnClass,
                        'data-method' => 'post',
                        'title' => 'Chuyển trạng thái'
                    ]);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>
</div>