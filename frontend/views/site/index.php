<?php
$this->title = "Trang chủ";
?>

<div class="row text-center mb-5">
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h3>🥬 Rau sạch</h3>
            <p>Tươi ngon từ nông trại Việt Nam</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h3>🥕 Củ quả tươi</h3>
            <p>Bảo quản tốt, giữ trọn dinh dưỡng</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h3>🍎 Trái cây</h3>
            <p>Ngọt lành từ vườn cây an toàn</p>
        </div>
    </div>
</div>

<h2 class="mb-4">Sản phẩm nổi bật</h2>
<div class="row">
    <!-- <?php foreach (\common\models\Product::find()->limit(8)->all() as $p): ?> -->
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="<?= $p->image ?>" class="card-img-top" style="height:200px;object-fit:cover;">
            <div class="card-body d-flex flex-column">
                <h5><?= $p->name ?></h5>
                <p class="text-success fw-bold"><?= number_format($p->price) ?> VNĐ</p>
                <a href="/product/view?id=<?= $p->id ?>" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
            </div>
        </div>

        <div class="card h-100 shadow-sm">
            <img src="c:\Users\ThanhDat-Cao\Desktop\CTD nè\hello.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
            <div class="card-body d-flex flex-column">
                <h5>Rau</h5>
                <p class="text-success fw-bold">100VNĐ</p>
                <a href="/product/view?id=<?= $p->id ?>" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
            </div>
        </div>
        <div class="card h-100 shadow-sm">
            <img src="<?= $p->image ?>" class="card-img-top" style="height:200px;object-fit:cover;">
            <div class="card-body d-flex flex-column">
                <h5><?= $p->name ?></h5>
                <p class="text-success fw-bold"><?= number_format($p->price) ?> VNĐ</p>
                <a href="/product/view?id=<?= $p->id ?>" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
            </div>
        </div>

        <h2> CTD </h2>
    </div>
    <!-- <?php endforeach; ?> -->
</div>