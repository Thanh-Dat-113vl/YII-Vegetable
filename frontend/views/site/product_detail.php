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

        <?php
                $this->registerJsFile('@web/js/cart.js', [
                    'depends' => [\yii\web\JqueryAsset::class],
                ]);
            ?>

            <button type="button" class="add-to-cart-btn btn btn-primary w-100 d-flex align-items-center justify-content-center text-uppercase fw-semibold text-white border-0 rounded-2 py-2 gap-2 gradient-btn"
                data-id="<?= $product->id ?>"
                data-name="<?= Html::encode($product->name) ?>"
                data-price="<?= $product->price * (100 - $product->discount) / 100 ?>"
                data-image="<?= Yii::getAlias('@web/uploads/' . $product->image) ?>">
                <i class="bi bi-cart-plus"></i> Mua ngay
            </button>


            <div>
                <small class="text-muted">Chia sẻ:</small>
                <a href="#" class="text-primary text-decoration-none ms-2"><i class="bi bi-facebook"></i> Facebook</a> •
                <a href="#" class="text-info text-decoration-none"><i class="bi bi-twitter"></i> Twitter</a>
            </div>
        </div>
    </div>
<!-- 
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".add-to-cart").forEach(btn => {
                btn.addEventListener("click", function() {
                    const data = {
                        id: this.dataset.id,
                        name: this.dataset.name,
                        price: this.dataset.price,
                        image: this.dataset.image
                    };

                    fetch('<?= \yii\helpers\Url::to(['site/add-to-cart']) ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-Token': '<?= Yii::$app->request->getCsrfToken() ?>'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                // ✅ Cập nhật badge ngay mà không reload
                                let badge = document.getElementById('cart-count');
                                if (badge) {
                                    badge.textContent = res.total;
                                    badge.classList.remove('d-none');
                                } else {
                                    // Nếu badge chưa tồn tại, tạo mới
                                    const cartLink = document.querySelector('.bi-cart').parentElement;
                                    const newBadge = document.createElement('span');
                                    newBadge.id = 'cart-count';
                                    newBadge.className = 'position-absolute start-100 translate-middle badge rounded-circle bg-danger';
                                    newBadge.style = 'font-size:10px; min-width:16px; height:16px; line-height:14px; top:15%';
                                    newBadge.textContent = res.total;
                                    cartLink.parentElement.appendChild(newBadge);
                                }

                                alert('Đã thêm vào giỏ hàng!');
                                document.querySelector("#cart-count").innerText = res.total;
                            } else {
                                alert('Lỗi thêm giỏ hàng!');
                            }
                        });
                });
            });
        });
    </script> -->