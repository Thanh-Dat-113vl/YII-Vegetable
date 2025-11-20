<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
$this->title = 'Order Details #' . $model->id;
?>

<div class="orders-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return $model->user ? $model->user->username : 'N/A';
                },
            ],
            [
                'attribute' => 'totalPrice',
                'value' => $model->total_price,
                'format' => ['currency', 'VND'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $statusLabels = [
                        'pending'   => ['Pending',   'badge bg-warning'],
                        'confirm'   => ['Confirm',   'badge bg-primary'],
                        'shipping'  => ['Shipping',  'badge bg-info text-dark'],
                        'completed' => ['Completed', 'badge bg-success'],
                        'canceled'  => ['Canceled',  'badge bg-danger'],
                    ];
                    if (isset($statusLabels[$model->status])) {
                        [$text, $class] = $statusLabels[$model->status];
                        return "<span class='{$class}' style='font-size:15px'>{$text}</span>";
                    }

                    return "<span class='badge bg-secondary'>Unknown</span>";
                },
            ],
            'created_at',
            'updated_at',

        ],
    ]) ?>
    <p>
        <?= Html::a('Back to Orders', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>