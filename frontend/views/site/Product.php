<h1>Sản phẩm rau củ</h1>
<div class="row">
    <?php foreach ($products as $p): ?>
        <div class="col-md-3">
            <div class="card">
                <img src="<?= $p->image ?>" class="card-img-top" />
                <div class="card-body">
                    <h5><?= $p->name ?></h5>
                    <p><?= number_format($p->price) ?> VNĐ</p>
                    <a href="/product/view?id=<?= $p->id ?>" class="btn btn-success">Xem</a>
                    <a href="/cart/add?id=<?= $p->id ?>" class="btn btn-primary">Thêm giỏ</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>