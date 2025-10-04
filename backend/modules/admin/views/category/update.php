<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Category */
$this->title = 'Update category: ' . $model->name;
?>
<div class="update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Hiển thị',
        0 => 'Ẩn'
    ]) ?>
    <div class="form-group mt-3">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this user?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="bi bi-arrow-left"></i> Back', ['index'], [
            'class' => 'btn btn-secondary ms-2'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>