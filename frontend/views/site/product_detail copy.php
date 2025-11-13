<?php

use yii\helpers\Html;
use yii\helpers\Url;



?>

<!-- card sản phẩm  -->
<div class="container my-4">
    <div class="row row-cols-1 row-cols-md-5 g-4">

        <!-- Card 1 -->
        <div class="col">
            <div class="card h-100 text-center shadow-sm">
                <img src="https://via.placeholder.com/150" class="card-img-top p-3" alt="Dầu đậu nành Simply 2 lít">
                <div class="card-body">
                    <h6 class="card-title">Dầu đậu nành Simply 2 lít</h6>
                    <p class="text-danger fw-bold fs-5 mb-1">115.000đ</p>
                    <p class="text-muted text-decoration-line-through mb-1">132.000đ</p>
                    <span class="badge bg-danger">-13%</span>
                </div>
                <div class="card-footer bg-white border-0">
                    <button class="btn btn-success w-100">MUA</button>
                </div>
            </div>
        </div>
    </div>
</div>


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




    <!-- js  -->


    <?php
    // JS xử lý click star và giới hạn file
    $this->registerJs(
        <<<JS
            (function(){
                var stars = document.querySelectorAll('#star-wrapper .star');
                var input = document.getElementById('review-rating');
                var label = document.getElementById('star-label');
        
                stars.forEach(function(s){
                    s.addEventListener('mouseenter', function(){ highlight(s.dataset.value); });
                    s.addEventListener('mouseleave', function(){ setFromValue(); });
                    s.addEventListener('click', function(){
                        input.value = s.dataset.value;
                        setFromValue();
                    });
                });
        
                function highlight(val){
                    stars.forEach(function(s){ s.style.color = (s.dataset.value <= val ? '#ffb000' : '#e4e4e4'); });
                }
                function setFromValue(){
                    const v = parseInt(input.value) || 0;
                    const level = = {
                        1: 'Rất tệ',
                        2: 'Tệ',
                        3: 'Bình thường',
                        4: 'Tốt',
                        5: 'Rất tốt'
                    }
                    stars.forEach(function(s){ s.style.color = (s.dataset.value <= v ? '#ffb000' : '#e4e4e4'); });
                    label.textContent = v ? levels[v] : 'Chọn đánh giá';
                }
        
                // giới hạn upload 3 ảnh
                // var imgInput = document.getElementById('review-images');
                // if(imgInput){
                //     imgInput.addEventListener('change', function(){
                //         if(this.files.length > 3){
                //             alert('Chỉ được gửi tối đa 3 ảnh');
                //             this.value = '';
                //         }
                //     });
                // }
        
            })();
        JS
    );

    $this->registerJs(
        <<<JS
        (function(){
            var ratingInput = document.getElementById('review-rating');
            var nameInput = document.querySelector('input[name="review_name"]');
            var phoneInput = document.querySelector('input[name="review_phone"]');
            var policy = document.getElementById('policyCheck');
            var submitBtn = document.getElementById('submit-review-btn');
        
            function validPhone(v){
                if(!v) return false;
                v = v.replace(/[^0-9+]/g, '');
                return /^\+?\d{7,15}$/.test(v);
            }
        
            function checkEnable(){
                var r = parseInt(ratingInput.value) || 0;
                var nameOk = nameInput && nameInput.value.trim().length > 0;
                var phoneOk = phoneInput && validPhone(phoneInput.value.trim());
                var policyOk = policy && policy.checked;
                if(r && nameOk && phoneOk && policyOk){
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }
        
            if(nameInput) nameInput.addEventListener('input', checkEnable);
            if(phoneInput) phoneInput.addEventListener('input', checkEnable);
            if(policy) policy.addEventListener('change', checkEnable);
            if(ratingInput) ratingInput.addEventListener('change', checkEnable);
        
            // khi user click star -> kích hoạt kiểm tra
            document.body.addEventListener('click', function(e){
                if(e.target && e.target.classList && e.target.classList.contains('star')){
                    setTimeout(checkEnable, 50);
                }
            });
    
            // khởi tạo trạng thái nút
            checkEnable();
        })();
        JS
    );
    ?>