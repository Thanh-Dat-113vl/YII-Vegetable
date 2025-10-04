<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\web\View $this */
/** @var array $categories */

$this->title = 'Manage Products';
?>

<div class="product-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Add product', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'price',
                'format' => ['currency', 'VND']
            ],


            [
                'attribute' => 'discount',
                'value' => function ($model) {
                    return $model->discount ? $model->discount . '%' : 'No Discount';
                }
            ],
            [
                'attribute' => 'price_after_discount',
                'value' => function ($model) {
                    $discountedPrice = $model->price * (1 - ($model->discount / 100));
                    return number_format($discountedPrice) . ' VND';
                },
                // 'format' => ['currency', 'VND'],
            ],
            [
                'attribute' => 'stock',
                'value' => function ($model) {
                    return $model->stock > 0 ? $model->stock : 'Out of stock';
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->name : 'N/A';
                },
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->image
                        ? \yii\helpers\Html::img(Yii::getAlias('@web/uploads/' . $model->image), ['width' => '100px'])
                        : null;
                },
            ],
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
            [
                'class' => 'yii\grid\ActionColumn'
            ],
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