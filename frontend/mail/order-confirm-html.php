<?php
/* @var $order \common\models\Orders */
?>
<div style="font-family:arial,helvetica,sans-serif; font-size:14px; color:#333;">
    <h2>Đơn hàng của bạn đã được nhận</h2>
    <p>Mã đơn: <strong><?= htmlspecialchars($order->order_code) ?></strong></p>
    <p>Tổng: <strong><?= number_format($order->total_price, 0, ',', '.') ?>đ</strong></p>
    <hr>
    <h4>Chi tiết</h4>
    <ul>
        <?php foreach ($order->items as $it): ?>
            <li><?= htmlspecialchars($it->product->name ?? 'Sản phẩm') ?> × <?= (int)$it->quantity ?> — <?= number_format($it->price * $it->quantity, 0, ',', '.') ?>đ</li>
        <?php endforeach; ?>
    </ul>
    <p>Chúng tôi sẽ liên hệ bạn sớm để xác nhận đơn hàng.</p>
    <p>Trân trọng,<br />VEGETABLE</p>
</div>