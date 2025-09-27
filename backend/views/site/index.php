<?php

/** @var yii\web\View $this */

$this->title = 'Trang Admin';
?>
<div class="site-index">
    <div>
        <p>
            <?= \yii\helpers\Html::a('📧 Test Mail', ['site/test-mail'], [
                'class' => 'btn btn-primary',
                'data-method' => 'post'
            ]) ?>
        </p>
    </div>