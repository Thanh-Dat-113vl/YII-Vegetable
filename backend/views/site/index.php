<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
?>
<div>

    <p>
        <?= \yii\helpers\Html::a('📧 Test Mail', ['site/test-mail'], [
            'class' => 'btn btn-primary',
            'data-method' => 'post'
        ]) ?>
    </p>


</div>