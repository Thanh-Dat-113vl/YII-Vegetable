<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Trang chủ";
?>
<div class="container py-3">

    <!-- BANNER -->
    <div id="mainBanner" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <?php
            $banners = [
                '/uploads/980x125-banner-thit-ca_202510141420357956.png',
                '/uploads/banner2.jpg',
                '/uploads/freecompress-trang-cate-pc_202510140920369124.jpg'
            ];
            foreach ($banners as $i => $img): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?> p-2">
                    <a href="#" class="d-block">
                        <div class="rounded-3" style="background:url('<?= $img ?>') center/cover no-repeat; min-height:120px;"></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <div class="carousel-indicators"></div>
    </div>



    <!-- FEATURES -->
    <div id="categoryCarousel" class="carousel slide bg-white rounded-3 p-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $chunks = array_chunk($category, 10);
            $active = "active";
            foreach ($chunks as $chunk):
            ?>
                <div class="carousel-item <?= $active ?>">
                    <div class="d-flex justify-content-around flex-wrap">
                        <?php foreach ($chunk as $c):
                            $name = is_object($c) ? $c->name : $c['name'];
                            $image = is_object($c) ? $c->image : $c['image'];
                        ?>
                            <div class="text-center p-2" style="width:90px;">
                                <a href="<?= Url::to(['site/search', 'keyword' => $name]) ?>"
                                    class="text-decoration-none small fw-medium text-truncate d-block category-link text-black"
                                    title="<?= Html::encode($name) ?>">
                                    <!-- <img src="<?= $image ?>" alt="<?= Html::encode($name) ?>"
                                        class="mb-2 rounded-circle shadow-sm"
                                        style="width:48px; height:48px; object-fit:cover;"> -->
                                    <div><?= Html::encode($name) ?></div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
                $active = ""; // chỉ active cho slide đầu
            endforeach;
            ?>
        </div>

        <!-- Nút điều hướng -->
        <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- PRODUCTS -->
    <h2 class="m-3">Sản phẩm nổi bật</h2>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
        <?php if (!empty($products)): foreach ($products as $p):
                // hỗ trợ object hoặc array
                $id = is_object($p) ? $p->id : $p['id'];
                $name = is_object($p) ? $p->name : $p['name'];
                $image = is_object($p) ? $p->image : $p['image'];
                $price = is_object($p) ? (float)$p->price : (float)$p['price'];
                $discount = is_object($p) ? (int)$p->discount : (int)$p['discount'];
                $unit = is_object($p) ? ($p->unit ?? '') : ($p['unit'] ?? '');
                $stock = is_object($p) ? ($p->stock ?? 0) : ($p['stock'] ?? 0);

                $priceSaleValue = $price * (100 - $discount) / 100;
                $priceSale = Yii::$app->formatter->asDecimal($priceSaleValue, 0) . '₫';
                $priceOrigin = Yii::$app->formatter->asDecimal($price, 0) . '₫';
        ?>
                <div class="col d-flex">
                    <div class="card product-card shadow-sm w-100 d-flex flex-column">
                        <a href="<?= Url::to(['product-detail', 'id' => $id]) ?>" class="text-decoration-none text-dark">
                            <img src="<?= Yii::getAlias('@web/uploads/' . $image) ?>" class="card-img-top" style="height:180px;object-fit:cover;" alt="<?= Html::encode($name) ?>">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-truncate mb-2" title="<?= Html::encode($name) ?>" style="font-size:16px; min-height:40px; font-weight:600;"><?= Html::encode($name) ?></h6>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class=" fw-bold" style="font-size:15px;">
                                        <?= Yii::$app->formatter->asDecimal($priceSaleValue, 0) ?>₫
                                        <small class="text-muted">/<?= Html::encode($unit) ?></small>
                                    </div>
                                </div>
                                <?php if ($discount > 0): ?>
                                    <div class="text-start d-flex">
                                        <div class="text-decoration-line-through text-muted me-2 mt-1" style="font-size:12px;"><?= $priceOrigin ?></div>
                                        <div class="badge bg-danger text-white" style="font-size:11px; margin-top:4px;">-<?= $discount ?>%</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="card-footer bg-transparent border-0 pt-0 px-3 pb-3 mt-auto">
                            <?php if ($stock > 0): ?>
                                <button type="button" class="add-to-cart-btn btn btn-outline-success w-100" data-id="<?= $id ?>"
                                    data-name="<?= Html::encode($name) ?>" data-price="<?= $priceSaleValue ?>"
                                    data-image="<?= Html::encode($image) ?>">
                                    <i class="bi bi-cart-plus"></i> Mua
                                </button>
                            <?php else: ?>
                                <div class="text-center text-muted small">TẠM HẾT HÀNG</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="col-12">
                <div class="alert alert-info">Không có sản phẩm</div>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php $this->registerJs(
    <<<'JS'
document.addEventListener('DOMContentLoaded', function() {
    var carousel = document.getElementById('mainBanner');
    if (!carousel) return;
    var inner = carousel.querySelector('.carousel-inner');
    if (!inner) return;
    var items = inner.querySelectorAll('.carousel-item');
    if (!items.length) return;

    // indicators
    var indicators = carousel.querySelector('.carousel-indicators');
    indicators.innerHTML = '';
    items.forEach(function(_, idx) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.setAttribute('data-bs-target', '#mainBanner');
        btn.setAttribute('data-bs-slide-to', String(idx));
        if (idx === 0) btn.classList.add('active');
        indicators.appendChild(btn);
    });
});


  var swiper = new Swiper(".category-swiper", {
    slidesPerView: 7,
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

JS
); ?>