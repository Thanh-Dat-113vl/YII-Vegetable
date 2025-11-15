<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Chi tiết đơn hàng #" . $order->id;
?>

<div class="">
    <div class="d-flex border-top border-bottom bg-light "
        style="border-color:#f2f5f9; border-width:2px 0; height:46px;">
        <button class="btn btn-link text-dark" style="width:46px;" onclick="window.history.back();">
            <i class="bi bi-chevron-left"></i> </button>
        <div class="flex-grow-1 d-flex align-items-center pt-3">
            <a class="text-decoration-none text-dark text-center">
                <h4 class="fw-bold mb-4"><i class="bi bi-receipt me-2"></i>Chi tiết đơn hàng #<?= $order->id ?></h4>
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 my-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 mb-2">
                    <strong>Ngày đặt hàng:</strong><br>
                    <?= Yii::$app->formatter->asDatetime($order->created_at) ?>
                </div>
                <div class="col-md-4 mb-2">
                    <strong>Trạng thái:</strong><br>
                    <?php
                    $map = [
                        'pending' => 'Đang xử lý',
                        'confirmed' => 'Đã xác nhận',
                        'completed' => 'Hoàn tất',
                        'canceled' => 'Đã huỷ',
                    ];
                    $statusClass = [
                        'pending' => 'badge bg-warning text-dark',
                        'confirmed' => 'badge bg-info text-dark',
                        'completed' => 'badge bg-success',
                        'canceled' => 'badge bg-danger',
                    ][$order->status] ?? 'badge bg-secondary';
                    ?>
                    <span class="<?= $statusClass ?>"><?= Html::encode($map[$order->status]) ?></span>

                </div>
                <div class="col-md-4 mb-2">
                    <strong>Tổng tiền:</strong><br>
                    <span class="fw-bold text-danger"><?= Yii::$app->formatter->asCurrency($order->total_price, 'VND') ?></span>
                </div>
            </div>

            <hr>

            <h6 class="fw-bold mb-3"><i class="bi bi-box-seam me-2"></i>Sản phẩm trong đơn</h6>

            <?php foreach ($order->items as $item): ?>
                <?php
                $product = $item->product;
                $img = Html::encode($product->image ?? 'no-image.png');
                $name = Html::encode($product->name ?? 'Sản phẩm không tồn tại');
                $price = Yii::$app->formatter->asDecimal($item->price, 0) . '₫';
                $total = Yii::$app->formatter->asDecimal($item->price * $item->quantity, 0) . '₫';
                ?>
                <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <img src="/uploads/<?= $img ?>" class="me-3 rounded" style="width:70px;height:70px;object-fit:cover;">
                        <div>
                            <div class="fw-semibold"><?= $name ?></div>
                            <div class="text-muted small">Đơn giá: <?= $price ?> × SL: <?= $item->quantity ?></div>
                        </div>
                    </div>
                    <div class="text-end fw-bold text-danger"><?= $total ?></div>
                </div>
            <?php endforeach; ?>

            <hr>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <strong>Ngày tạo:</strong> <?= Yii::$app->formatter->asDatetime($order->created_at) ?>
                </div>
                <div class="fw-bold fs-5 text-danger">
                    Tổng cộng: <?= Yii::$app->formatter->asCurrency($order->total_price, 'VND') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end">
        <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-success">
            <i class="bi bi-shop"></i> Tiếp tục mua hàng
        </a>
    </div>
</div>