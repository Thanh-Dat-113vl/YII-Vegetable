<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Product $model */


$this->title = 'Review Product: ' . $model->name;
?>

<div class="product-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'name',
                'label' => 'Product Name'
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->creator ? $model->creator->username : 'N/A',
                'label' => 'Creator'
            ],
            [
                'attribute' => 'price',
                'value' => function ($model) {
                    return number_format($model->price) . ' VND';
                },
                'label' => 'Price'
            ],
            [
                'attribute' => 'discount',
                'value' => function ($model) {
                    return $model->discount ? $model->discount . '%' : '0%';
                }
            ],
            [
                'attribute' => 'price_after_discount',
                'value' => function ($model) {
                    $discountedPrice = $model->price * (1 - ($model->discount / 100));
                    return number_format($discountedPrice) . ' VND';
                },
            ],
            [
                'attribute' => 'category_id',
                'value' => $model->category->name,
                'label' => 'Category'
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
            ],
            'stock',
            [
                'attribute' => 'status',
                'value' => $model->status ? 'Show' : 'Hide',
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d-m-Y H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:d-m-Y H:i:s'],
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->image ? Html::img(Yii::getAlias('@web/uploads/' . $model->image), ['width' => '150']) : null;
                }
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Bạn có chắc chắn muốn xóa?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
</div>