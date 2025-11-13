<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$this->title = "Chi tiết sản phẩm";

$this->registerJsFile('@web/js/rating.js', ['depends' => [\yii\web\JqueryAsset::class]]);


?>


<div class="" style="min-height:100vh ;margin-bottom:20px">
    <div class="d-flex border-top border-bottom bg-light "
        style="border-color:#f2f5f9; border-width:2px 0; height:46px;">
        <button class="btn btn-link text-dark" style="width:46px;" onclick="window.history.back();">
            <i class="bi bi-chevron-left"></i> </button>
        <div class="flex-grow-1 d-flex align-items-center ">
            <a class="text-decoration-none text-dark text-center">
                <?= $category->name ?>
            </a>
        </div>
    </div>


    <!-- Vùng chi tiết sản phẩm -->
    <div class="product-container p-4 d-flex gap-4 mt-2">
        <!-- Bên trái: hình ảnh -->
        <div class="product-left">
            <img src="<?= Yii::getAlias('@web/uploads/' . $product->image) ?>" alt="Sản phẩm"
                class="product-img-main mb-3">
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
                <span class="text-danger fs-4 fw-bold">
                    <?= Yii::$app->formatter->asDecimal($product->price * (100 - $product->discount) / 100, 0) ?>₫</span>
                <?php if ($product->discount > 0) : ?>
                    <span
                        class="text-decoration-line-through text-muted ms-2"><?= Yii::$app->formatter->asDecimal($product->price, 0) ?></span>
                    <span class="badge bg-danger ms-2">-<?= $product->discount ?>%</span>
                <?php endif; ?>

                <p>Đơn vị: <?= $product->unit ?></p>
            </div>
            <p class="text-muted"><?= $product->description ?></p>

            <?php
            $this->registerJsFile('@web/js/cart.js', [
                'depends' => [\yii\web\JqueryAsset::class],
            ]);
            ?>
            <?php if ($product->stock > 0) : ?>
                <button type="button"
                    class="add-to-cart-btn btn btn-primary w-100 d-flex align-items-center justify-content-center text-uppercase fw-semibold text-white border-0 rounded-2 py-2 gap-2 gradient-btn"
                    data-id="<?= $product->id ?>" data-name="<?= Html::encode($product->name) ?>"
                    data-price="<?= $product->price * (100 - $product->discount) / 100 ?>"
                    data-image="<?= Yii::getAlias('@web/uploads/' . $product->image) ?>">
                    <i class="bi bi-cart-plus"></i> Mua ngay
                </button>
            <?php else: ?>
                <div class=" text-center mt-auto text-body-tertiary text-bord text-uppercase fs-6">
                    TẠM HẾT HÀNG
                </div>
            <?php endif;   ?>



            <div>
                <small class="text-muted">Chia sẻ:</small>
                <a href="#" class="text-primary text-decoration-none ms-2"><i class="bi bi-facebook"></i> Facebook</a> •
                <a href="#" class="text-info text-decoration-none"><i class="bi bi-twitter"></i> Twitter</a>
            </div>
        </div>
    </div>

    <!-- Reviews -->
    <div class="mt-4 bg-light p-4 rounded-3">
        <h5>Đánh giá (<?= count($review ?? []) ?>)</h5>

        <?php if (!empty($review)): ?>
            <div class="list-group mb-3">
                <?php foreach ($review as $r): ?>
                    <?php if ($r->status == 1): ?>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong><?= Html::encode($r->user->username ?? 'Người dùng') ?></strong>
                                    <div class="small text-muted"><?= Yii::$app->formatter->asDatetime($r->created_at) ?></div>
                                </div>
                                <div class="text-end">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $r->rating): ?>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        <?php else: ?>
                                            <i class="bi bi-star text-secondary"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <?php if ($r->comment): ?>
                                <p class="mt-2 mb-0"><?= Html::encode($r->comment) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-muted mb-3">Chưa có đánh giá nào.</div>
        <?php endif; ?>

        <!-- Trigger / nếu chưa login thì yêu cầu login -->
        <?php if (Yii::$app->user->isGuest): ?>
            <p>Vui lòng <?= Html::a('đăng nhập', ['site/login']) ?> để đánh giá sản phẩm.</p>
        <?php else: ?>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                Viết đánh giá
            </button>

            <!-- Modal đánh giá -->
            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form id="review-modal-form" method="POST"
                            action="<?= Url::to(['review/create', 'product_id' => $product->id]) ?>" enctype="multipart/form-data">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Stars -->
                                <div class="text-center mb-3">
                                    <div id="star-wrapper" class="fs-1">
                                        <i class="bi bi-star star" data-value="1" style="cursor:pointer;color:#e4e4e4"></i>
                                        <i class="bi bi-star star" data-value="2" style="cursor:pointer;color:#e4e4e4"></i>
                                        <i class="bi bi-star star" data-value="3" style="cursor:pointer;color:#e4e4e4"></i>
                                        <i class="bi bi-star star" data-value="4" style="cursor:pointer;color:#e4e4e4"></i>
                                        <i class="bi bi-star star" data-value="5" style="cursor:pointer;color:#e4e4e4"></i>
                                    </div>
                                    <div class="small text-muted mt-1" id="star-label">Chọn đánh giá</div>
                                </div>
                                <!-- rating -->
                                <input type="hidden" name="Review[rating]" id="review-rating" value="">
                                <!-- nội dung -->
                                <div class="mb-3">
                                    <textarea name="Review[comment]" class="form-control" rows="4"
                                        placeholder="Mời bạn chia sẻ thêm cảm nhận..."></textarea>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="shareCheck" name="share_to_friends">
                                    <label class="form-check-label" for="shareCheck">Tôi sẽ giới thiệu sản phẩm cho bạn bè,
                                        người thân</label>
                                </div>
                                <!-- thông tin người đánh giá -->
                                <div class="row g-2 mb-2">
                                    <div class="col">
                                        <label type="text">Họ tên:</label>
                                        <input type="text" name="Review[review_name]" class="form-control"
                                            placeholder="Họ tên (bắt buộc)">
                                    </div>
                                    <div class="col">
                                        <label type="text">Số điện thoại:</label>
                                        <input type="text" name="Review[review_phone]" class="form-control"
                                            placeholder="Số điện thoại (bắt buộc)">
                                    </div>
                                </div>
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="policyCheck" required>
                                    <label class="form-check-label" for="policyCheck">Tôi đồng ý với Chính sách bảo mật
                                        thông tin</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <!-- disabled ban đầu, sẽ bật khi đủ điều kiện -->
                                <button type="submit" id="submit-review-btn" class="btn btn-success" disabled>Gửi đánh
                                    giá</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--  -->
        <?php endif; ?>
    </div>
</div>