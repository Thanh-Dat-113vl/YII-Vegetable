<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var $model \frontend\models\LoginForm */

$this->title = 'Đăng nhập';
?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center"><?= Html::encode($this->title) ?></h2>

        <?php $form = ActiveForm::begin([
            'id' => 'LoginForm',
            'layout' => 'default',
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Tên đăng nhập']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mật khẩu']) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="d-grid">
            <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary btn-lg']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <hr>
        <p class="text-center">
            Chưa có tài khoản? <?= Html::a('Đăng ký ngay', ['/site/signup']) ?>
        </p>
    </div>
</div>