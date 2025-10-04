<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Category */
$this->title = 'Add New Category';
?>
<div class="create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'needs-validation'],
    ]); ?>

    <div class="mb-3">
        <?= $form->field($model, 'name', [
            'labelOptions' => ['class' => 'form-label fw-semibold'],
        ])->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'name of category',
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'slug', [
            'labelOptions' => ['class' => 'form-label fw-semibold'],
        ])->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'slug-tieu-de-khong-dau',
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'status', [
            'labelOptions' => ['class' => 'form-label fw-semibold'],
        ])->dropDownList([
            1 => '✅ Show',
            0 => '🚫 Hide'
        ], ['class' => 'form-select']) ?>
    </div>

    <div class="pt-2">
        <?= Html::submitButton('<i class="bi bi-save"></i> Lưu', [
            'class' => 'btn btn-success px-4'
        ]) ?>
        <?= Html::a('<i class="bi bi-arrow-left"></i> Back', ['index'], [
            'class' => 'btn btn-secondary ms-2'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>