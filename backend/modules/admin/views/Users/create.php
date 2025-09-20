<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Craete User Account';

?>

<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form ">

        <?php $form = ActiveForm::begin(); ?>
        <div class="mb-3"><?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?></div>
        <div class="mb-3"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
        <div class="mb-3"><?= $form->field($model, 'password')->passwordInput(['value' => ''])->hint('Mật khẩu > 8 ký tự, gồm chữ, số và ký tự đặt biệt') ?></div>
        <div class="mb-3">
            <?= $form->field($model, 'role', [
                'labelOptions' => ['class' => 'form-label fw-semibold'],
            ])->dropDownList([
                0 => 'admin',
                1 => 'employee',
                2 => 'customer'
            ], ['class' => 'form-select ']) ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'status', [
                'labelOptions' => ['class' => 'form-label fw-semibold'],
            ])->dropDownList([
                1 => '✅ Show',
                0 => '🚫 Hide'
            ], ['class' => 'form-select']) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="bi bi-arrow-left"></i> Back', ['index'], [
                'class' => 'btn btn-secondary ms-2 '
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>