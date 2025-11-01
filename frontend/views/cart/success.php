<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $order \common\models\Orders */

$this->title = 'Đặt hàng thành công';
?>
<div class="container py-4">
    <div class="card p-4 shadow-sm text-center">
        <h3 class="text-success mb-2">Cám ơn bạn, đơn hàng đã được gửi</h3>
        <p class="mb-1">Mã đơn hàng: <strong><?= Html::encode($order->order_code) ?></strong></p>
        <p class="mb-1">Tổng tiền: <strong><?= number_format($order->total_price, 0, ',', '.') ?>đ</strong></p>
        <p class="mb-3">Trạng thái: <strong><?= Html::encode($order->getStatusLabel()) ?></strong></p>

        <div class="d-flex justify-content-center gap-2">
            <?= Html::a('Xem đơn hàng', ['order/view', 'id' => $order->id], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Tiếp tục mua hàng', ['site/index'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>