<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Trang chủ";
?>

<!-- BANNER -->
<div id="mainBanner" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <a href="#">
                <div class="d-flex align-items-center justify-content-center text-white text-center"
                    style="background: url('/images/banner1.jpg') center/cover no-repeat; min-height: 300px;">
                    <div class="bg-dark bg-opacity-50 p-5 rounded">
                        <h1 class="display-5 fw-bold">CTD - Banner 1</h1>
                        <p class="lead">Thông điệp banner số 1</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <a href="#">
                <div class="d-flex align-items-center justify-content-center text-white text-center"
                    style="background: url('/images/banner2.jpg') center/cover no-repeat; min-height: 300px;">
                    <div class="bg-dark bg-opacity-50 p-5 rounded">
                        <h1 class="display-5 fw-bold">CTD - Banner 2</h1>
                        <p class="lead">Thông điệp banner số 2</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Nút điều khiển -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        <!-- Chấm tròn điều hướng -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="2"></button>
        </div>
    </div>


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
    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4">

            <?php foreach ($products as $p): ?>
                <div class="col">
                    <a href="<?= Url::to(['product-detail', 'id' => $p->id]) ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= Yii::getAlias('@web/uploads/' . $p['image']) ?>"
                                class="card-img-top" style="height:200px;object-fit:cover;" />
                            <div class="card-body d-flex flex-column">
                                <h5 class="text-black"><?= $p->name ?></h5>
                                <span class="d-flex fw-bold mt-1"
                                    style="font-size:16px; line-height:16px; color:#192038;">
                                    <?= Yii::$app->formatter->asDecimal($p->price * (100 - $p->discount) / 100, 0) ?>đ/<?= $p->unit ?>
                                </span>

                                <!-- <p class="text-success fw-bold"><?= Yii::$app->formatter->asDecimal($p->price * (100 - $p->discount) / 100, 0) ?> đ</p> -->
                                <div class="mb-2px block leading-3">
                                    <?php if ($p->discount > 0): ?>
                                        <!-- giá discount -->
                                        <span class="text-decoration-line-through" style="color:#9DA7BC; font-size:11px; line-height:0;"> <?= Yii::$app->formatter->asDecimal($p->price, 0) ?>đ</span>
                                        <span class="fw-bold text-white text-center d-inline-block"
                                            style="margin-left:3px; width:30px; border-radius:2px; background-color:rgba(255,1,1,0.7); padding:2px 3px; font-size:9px; line-height:12px;">

                                            <span class="mr-1px">-</span><?= $p->discount ?>%</span>
                                    <?php endif; ?>

                                </div>
                                <!-- start -->
                                <div class="mb-2 text-warning">
                                    <?php
                                    $fullStars = floor($p->rating);
                                    $halfStar  = ($p->rating - $fullStars >= 0.5) ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;

                                    for ($i = 0; $i < $fullStars; $i++) echo '<i class="fa fa-star"></i>';
                                    if ($halfStar) echo '<i class="fa fa-star-half-o"></i>';
                                    for ($i = 0; $i < $emptyStars; $i++) echo '<i class="fa fa-star-o"></i>';
                                    ?>
                                    <span class="text-muted ms-2">(12 đánh giá)</span>
                                </div>
                            </a>
                                <!-- <a href="#" class="btn btn-outline-success mt-auto">Mua</a> -->
                                <button type="button" class=" add-to-cart-btn btn btn-outline-success mt-auto"
                                    data-id="<?= $p->id ?>"
                                    data-name="<?= Html::encode($p->name) ?>"
                                    data-price="<?= $p->price * (100 - $p->discount) / 100 ?>"
                                     data-image="<?= Html::encode($p->image) ?>">
                                    <i class="bi bi-cart-plus"></i> Mua
                                
                                </button>
                                
                            </div>
                        </div>
                    
                </div>
            <?php endforeach; ?>




        </div>
    </div>