<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Thanh toán';
?>
<div class="container py-4">
    <h3 class="mb-4"><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-md-8">
            <form method="post" action="<?= Url::to(['cart/checkout']) ?>">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ nhận hàng</label>
                    <input type="text" name="address" class="form-control" required placeholder="Địa chỉ nhận hàng">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phương thức thanh toán</label>
                    <select name="payment" class="form-select">
                        <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                        <option value="bank">Chuyển khoản</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success btn-lg">Xác nhận và đặt hàng</button>
                    <?= Html::a('Quay về giỏ hàng', ['site/cart'], ['class' => 'btn btn-link']) ?>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tóm tắt đơn hàng</h5>
                    <ul class="list-unstyled">
                        <?php $subtotal = 0;
                        foreach ($cart as $it):
                            $line = $it['price'] * $it['quantity'];
                            $subtotal += $line;
                        ?>
                            <li class="d-flex justify-content-between">
                                <div><?= Html::encode($it['name']) ?> × <?= (int)$it['quantity'] ?></div>
                                <div><?= number_format($line, 0, ',', '.') ?>đ</div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <div>Tạm tính</div>
                        <div><?= number_format($subtotal, 0, ',', '.') ?>đ</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Phí vận chuyển</div>
                        <div>15.000đ</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 text-success">
                        <div>Tổng</div>
                        <div><?= number_format($subtotal + 15000, 0, ',', '.') ?>đ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>