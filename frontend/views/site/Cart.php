<?php

use yii\helpers\Html;

/** @var $products common\models\Product[] */
/** @var $cart array */
$this->title = "Giỏ hàng";
?>

<h1 class="mb-4">🛒 Giỏ hàng của bạn</h1>

<?php if (empty($cart)): ?>
    <div class="alert alert-info">Giỏ hàng đang trống.
        <?= Html::a("Mua ngay", ['site/index'], ['class' => 'btn btn-success ms-3']) ?>
    </div>
<?php else: ?>
    <form method="post" action="/cart/checkout">
        <table class="table table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php $sum = 0;
                foreach ($products as $p):
                    $qty = $cart[$p->id];
                    $line = $qty * $p->price;
                    $sum += $line;
                ?>
                    <tr>
                        <td><?= Html::a($p->name, ['/product/view', 'id' => $p->id]) ?></td>
                        <td><img src="<?= $p->image ?>" style="width:80px;height:80px;object-fit:cover;"></td>
                        <td>
                            <input type="number" name="qty[<?= $p->id ?>]" value="<?= $qty ?>" min="1" class="form-control" style="width:80px">
                        </td>
                        <td><?= number_format($p->price) ?> VNĐ</td>
                        <td class="fw-bold text-success"><?= number_format($line) ?> VNĐ</td>
                        <td>
                            <a href="/cart/remove?id=<?= $p->id ?>" class="btn btn-sm btn-danger">X</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-light">
                    <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                    <td colspan="2" class="fw-bold text-danger"><?= number_format($sum) ?> VNĐ</td>
                </tr>
            </tbody>
        </table>
        <div class="text-end">
            <?= Html::a("Tiếp tục mua hàng", ['/product/index'], ['class' => 'btn btn-outline-secondary']) ?>
            <button type="submit" class="btn btn-success">Thanh toán</button>
        </div>
    </form>
<?php endif; ?>