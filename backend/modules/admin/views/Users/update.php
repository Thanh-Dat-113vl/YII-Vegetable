<?php

use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


$this->title = 'Update User: ' . $model->username; ?>


<div class="update">

    <?php $form = yii\widgets\ActiveForm::begin(); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'phone')->textInput([
        'maxlength' => true,
        'pattern' => '0[0-9]{9}',    // regex HTML5
        'title' => 'Nhập số điện thoại 10 số, bắt đầu bằng 0',
        'oninput' => 'this.value = this.value.replace(/[^0-9]/g, "").slice(0,10);'
    ]); ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']); ?>
    <?= $form->field($model, 'role')->dropDownList([
        0 => 'admin',
        1 => 'employee',
        2 => 'customer'
    ]); ?>


    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Active',
        0 => 'Inactive'
    ]); ?>


    <p class="mt-3">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this user?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back to list', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?php yii\widgets\ActiveForm::end(); ?>
</div>