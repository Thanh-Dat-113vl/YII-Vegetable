<?php

namespace common\models;

use yii\helpers\Html;
use Yii;
use yii\widgets\ActiveForm;

$this->title = 'Update Product: ' . $model->name;
?>
<div class="update">
    <?php $form = ActiveForm::begin(); ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'category_id')->dropDownList(
        $categories,
        [
            'prompt' => 'Select Category',
            'class' => 'form-select w-50'
        ]
    ) ?>
    <div class="position-relative">
        <?= $form->field($model, 'price', [
            'template' => "{label}\n<div class=\"input-group\">{input}<span class=\"input-group-text\">VND</span></div>\n{error}",
        ])->textInput([
            'type' => 'number',
            'min' => 0,
            'class' => 'form-control pe-5',
            'placeholder' => '0'
        ]) ?>
        <?= $form->field($model, 'discount')->textInput(['type' => 'number', 'min' => 0, 'max' => 100, 'class' => 'form-control w-50']) ?>
        <?= $form->field($model, 'stock')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control w-50']) ?>
        <?= $form->field($model, 'status')->dropDownList([
            1 => 'Show',
            0 => 'Hide'
        ], ['class' => 'form-select w-50']) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
        <div class="mb-3 mt-5">
            <?= $form->field($model, 'image')->fileInput() ?>
            <?php if (!$model->isNewRecord && $model->image): ?>
                <div class="mb-3">
                    <img src="<?= Yii::getAlias('@web/uploads/' . $model->image) ?>" width="150">
                </div>
            <?php endif; ?>

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

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>