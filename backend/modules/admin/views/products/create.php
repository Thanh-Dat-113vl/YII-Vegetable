<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Product */
/** @var $categories array */

$this->title = 'Thêm sản phẩm';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="product-create">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $categories,
        ['prompt' => 'Chọn danh mục']
    ) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'min' => 0]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Hiển thị',
        0 => 'Ẩn'
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>