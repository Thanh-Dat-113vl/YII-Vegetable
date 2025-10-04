<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Product */
/** @var $categories array */

$this->title = 'Create Productions';
?>

<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<div class="create mt-4 mb-5 p-4 border rounded" style="background: #f9f9f9;">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'class' => 'form-control  border-1 ',
    ]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $categories,
        ['prompt' => 'Select Category']
    ) ?>

    <div class="position-relative">
        <?= $form->field($model, 'price', [
            'template' => "{label}\n{input}\n{error}",
        ])->textInput([
            'type' => 'number',
            'min' => 0,
            'class' => 'form-control pe-5',
            'placeholder' => '0'
        ]) ?>
        <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted">VND</span>
    </div>
    <?= $form->field($model, 'unit')->textInput([
        'maxlength' => true,
        'placeholder' => 'cái, piece, kg, ...',
    ]) ?>
    <?= $form->field($model, 'discount')->textInput(['type' => 'number', 'min' => 0, 'max' => 100]) ?>


    <?= $form->field($model, 'stock')->textInput(['type' => 'number', 'min' => 0]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Show',
        0 => 'Hide'
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

    <div class="mb-3 mt-5">
        <?= $form->field($model, 'image')->fileInput() ?>
        <?php if (!$model->isNewRecord && $model->image): ?>
            <div class="mb-3">
                <img src="<?= Yii::getAlias('@web/uploads/' . $model->image) ?>" width="150">
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>