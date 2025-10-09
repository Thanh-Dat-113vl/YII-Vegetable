<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var frontend\models\Product $product */
/** @var frontend\models\Category $category */

?>


<div class="" style="min-height:100vh ;margin-bottom:20px">
    <div class="d-flex border-top border-bottom bg-light "
        style="border-color:#f2f5f9; border-width:2px 0; height:46px;">
        <button class="btn btn-link text-dark" style="width:46px;"
            onclick="window.history.back();">
            <i class="bi bi-chevron-left"></i> </button>
        <div class="flex-grow-1 d-flex align-items-center ">
            <a class="text-decoration-none text-dark text-center">
                <?= $category->name ?>
            </a>
        </div>
    </div>


    <!-- Vùng chi tiết sản phẩm -->
    <div class="product-container">
        <!-- Bên trái: hình ảnh -->
        <div class="product-left">
            <img src="<?= Yii::getAlias('@web/uploads/' . $product->image) ?>"
                alt="Sản phẩm" class="product-img-main mb-3">
            <div class="d-flex flex-wrap gap-2">
                <img src="<?= Yii::getAlias('@web/uploads/' . $product->image) ?>" class="thumb-img">
                <img src="<?= Yii::getAlias('@web/uploads/' . $product->image) ?>" class="thumb-img">
                <img src="<?= Yii::getAlias('@web/uploads/' . $product->image) ?>" class="thumb-img">

            </div>
        </div>

        <!-- Bên phải: thông tin -->
        <div class="product-right">
            <h5 class="fw-bold"><?= $product->name ?></h5>
            <div class="my-3">
                <span class="text-danger fs-4 fw-bold"> <?= Yii::$app->formatter->asDecimal($product->price * (100 - $product->discount) / 100, 0) ?></span>
                <span class="text-decoration-line-through text-muted ms-2"><?= Yii::$app->formatter->asDecimal($product->price, 0) ?></span>
                <span class="badge bg-danger ms-2">-<?= $product->discount ?>%</span>
                <p>Đơn vị: <?= $product->unit ?></p>
            </div>
            <p class="text-muted"><?= $product->description ?></p>

            <button type="button" class="btn btn-primary w-100 d-flex align-items-center justify-content-center text-uppercase fw-semibold text-white border-0 rounded-2 py-2 gap-2 gradient-btn">
                <i class="bi bi-cart-plus"></i> Mua ngay
            </button>


            <div>
                <small class="text-muted">Chia sẻ:</small>
                <a href="#" class="text-primary text-decoration-none ms-2"><i class="bi bi-facebook"></i> Facebook</a> •
                <a href="#" class="text-info text-decoration-none"><i class="bi bi-twitter"></i> Twitter</a>
            </div>
        </div>
    </div>

    <!-- <div class="related-products">
        <h5 class="fw-bold mb-3">Sản phẩm liên quan</h5>
     <?php foreach ($product as $rp): ?>
         <div class="card related-card" style="width: 180px;">
                <img src="<?= Yii::getAlias('@web/uploads/' . $rp->image) ?>" class="card-img-top" alt="...">
                <div class="card-body p-2">
                    <h6 class="card-title text-truncate"><?= $rp->name ?></h6>
                    <p class="text-danger mb-1 fw-bold"><?= Yii::$app->formatter->asDecimal(
                                                            $rp->price * (100 - $rp->discount) / 100,
                                                            0
                                                        ) ?>đ</p>
                    <a href="<?= Url::to(['product-detail', 'id' => $rp->id]) ?>" class="btn btn-outline-success w-100 btn-sm">Xem</a>
                </div>
            </div>
        <?php endforeach; ?> -->
    <!-- <div class="d-flex flex-wrap gap-3">
        
            <div class="card related-card" style="width: 180px;">
                <img src="https://cdn.tgdd.vn/Products/Images/2386/259287/bhx/nuoc-tay-rua-vim-chanh-880ml-202112081415099700.jpg" class="card-img-top" alt="...">
                <div class="card-body p-2">
                    <h6 class="card-title text-truncate">Nước tẩy VIM hương chanh 880ml</h6>
                    <p class="text-danger mb-1 fw-bold">30.000đ</p>
                    <a href="#" class="btn btn-outline-success w-100 btn-sm">Xem</a>
                </div>
            </div>

        </div> -->