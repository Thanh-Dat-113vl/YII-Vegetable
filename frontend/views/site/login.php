<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var $model \frontend\models\LoginForm */

$this->title = 'Đăng nhập';
?>
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg,#f4f7fb 0%,#e9f1ee 100%);">
    <div class="card shadow-lg" style="max-width:920px; width:100%; border-radius:12px; overflow:hidden;">
        <div class="row g-0">
            <div class="col-12 col-md-6 d-none d-md-flex align-items-center justify-content-center" style="background: url('/images/login-hero.jpg') center/cover no-repeat;">
                <!-- optional brand / promo -->
                <div class="text-center text-white px-4">
                    <h2 class="fw-bold mb-2">VEGETABLE</h2>
                    <p class="mb-0">Tươi sạch mỗi ngày — Mua sắm nhanh chóng, giao hàng tận nơi.</p>
                </div>
            </div>

            <div class="col-12 col-md-6 p-4 p-md-5">
                <div class="mb-3 text-center">
                    <a href="/" class="text-decoration-none text-success">
                        <h3 class="fw-bold mb-1">VEGETABLE</h3>
                    </a>
                    <p class="text-muted small mb-0">Đăng nhập vào tài khoản của bạn</p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'LoginForm',
                    'options' => ['autocomplete' => 'off'],
                ]); ?>

                <?= $form->field($model, 'username', [
                    'template' => '<div class="input-group mb-3"><span class="input-group-text bg-white"><i class="bi bi-person"></i></span>{input}</div>{error}',
                ])->textInput(['autofocus' => true, 'placeholder' => 'Tên đăng nhập', 'class' => 'form-control']) ?>

                <?= $form->field($model, 'password', [
                    'template' => '<div class="input-group mb-2"><span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>{input}</div>{error}',
                ])->passwordInput(['placeholder' => 'Mật khẩu', 'class' => 'form-control']) ?>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <?= $form->field($model, 'rememberMe', [
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['class' => 'form-check-label ms-2'],
                            'options' => ['class' => 'form-check d-flex align-items-center mb-0']
                        ])->checkbox(['class' => 'form-check-input']) ?>
                    </div>

                    <div>
                        <?= Html::a('Quên mật khẩu?', ['site/request-password-reset'], ['class' => 'small text-decoration-none']) ?>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-success btn-lg']) ?>
                </div>

                <div class="text-center mb-3">
                    <small class="text-muted">Hoặc tiếp tục với</small>
                </div>

                <div class="d-flex gap-2 mb-3">
                    <a href="#" class="btn btn-outline-secondary w-100"><i class="bi bi-google me-2"></i>Google</a>
                    <a href="#" class="btn btn-outline-primary w-100"><i class="bi bi-facebook me-2"></i>Facebook</a>
                </div>

                <div class="text-center">
                    <small class="text-muted">Chưa có tài khoản? <?= Html::a('Đăng ký ngay', ['/site/signup'], ['class' => 'fw-semibold text-success text-decoration-none']) ?></small>
                </div>

                <?php ActiveForm::end(); ?>

                <div class="mt-4 text-center small text-muted">
                    Bằng việc tiếp tục, bạn đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a>.
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// small style tweaks to keep consistent look
$this->registerCss(
    <<<'CSS'
.card { border: none; }
.input-group-text { border-right: 0; }
.input-group .form-control { border-left: 0; }
@media (max-width:575.98px) {
    .card .col-md-6.d-none.d-md-flex { display:none !important; }
}
CSS
);
?>