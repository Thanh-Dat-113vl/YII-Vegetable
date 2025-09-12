<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Category */
$this->title = 'Cập nhật Danh mục: ' . $model->name;
?>
<div class="category-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Hiển thị',
        0 => 'Ẩn'
    ]) ?>
    <div class="form-group mt-3">
        <?= Html::submitButton('Lưu thay đổi', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="bi bi-arrow-left"></i> Quay lại', ['index'], [
            'class' => 'btn btn-secondary ms-2'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>