<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'View Rating #' . $model->id;
?>
<div class="rating-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Approve', ['approve', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this rating?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= Html::encode($model->id) ?></td>
        </tr>
        <tr>
            <th>Product</th>
            <td><?= Html::encode($model->product ? $model->product->name : 'N/A') ?></td>
        </tr>
        <tr>
            <th>User</th>
            <td><?= Html::encode($model->user ? $model->user->username : 'N/A') ?></td>
        </tr>
        <tr>
            <th>Rename</th>
            <td><?= Html::encode($model->review_name) ?></td>
        </tr>
        <tr>
            <th>Rating</th>
            <td><?= Html::encode($model->rating) ?></td>
        </tr>
        <tr>
            <th>Comment</th>
            <td><?= Html::encode($model->comment) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= Html::encode($model->status ? 'Approved' : 'Pending') ?></td>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?= Html::encode($model->created_at) ?></td>
        </tr>
    </table>

    <p>
        <?= Html::a('Back to Ratings', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>