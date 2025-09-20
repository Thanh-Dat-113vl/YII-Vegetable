<?php

use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'Quản lý sản phẩm ';
?>

<div class="product-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Thêm Sản phẩm', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'price',
            'category.name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>