<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Manage Categories';  //Quản lý danh mục
?>
<div class="category-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?></p>

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
                    $label = $model->status ? 'Show' : 'Hide';
                    return Html::a($label, $url, [
                        'class' => $btnClass,
                        'data-method' => 'post',
                        'title' => 'Chuyển trạng thái'
                    ]);
                },
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
    ]) ?>
</div>