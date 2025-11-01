<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\models\Banner;
use yii\helpers\Url;


$banners = Banner::find()->where(['status' => 1])->all();


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<?php
$this->registerJsFile('@web/js/cart.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
?>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?> | VEGETABLE Online</title>
    <?php $this->head() ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <?= Html::csrfMetaTags() ?>

</head>

<body style="background-color:#e9ecef;">
    <div class="wrapper">
        <?php $this->beginBody() ?>

        <!-- HEADER -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="/">VEGETABLE</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- search: icon inside input -->
                    <form class="d-flex ms-auto my-2 my-lg-0" role="search"
                        onsubmit="event.preventDefault(); window.location.href='<?= Url::to(['site/search']) ?>?keyword='+encodeURIComponent(this.querySelector('[name=keyword]').value);">
                        <div class="input-group" style="min-width:160px; max-width:420px;">
                            <span class="input-group-text bg-white border-1" id="search-addon" style="border-radius:999px 0 0 999px;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input class="form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search"
                                name="keyword" style="border-radius:0 999px 999px 0;" />
                        </div>
                    </form>

                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <?php
                        $cookies = Yii::$app->request->cookies;
                        $cartCount = 0;
                        if ($cookies->has('cart')) {
                            $cart = json_decode($cookies->getValue('cart'), true);
                            $cartCount = is_array($cart) ? count($cart) : 0;
                        }
                        ?>
                        <li class="nav-item position-relative me-2">
                            <?= Html::a('<i class="bi bi-cart"></i>', ['site/cart'], [
                                'class' => 'nav-link position-relative',
                                'encode' => false,
                                'title' => 'Giỏ hàng',
                            ]) ?>
                            <?php if ($cartCount > 0): ?>
                                <span id="cart-count" class="position-absolute start-100 translate-middle badge rounded-circle bg-danger"
                                    style="font-size:10px; min-width:16px; height:16px; line-height:9px; top:10%"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </li>

                        <?php if (Yii::$app->user->isGuest): ?>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['site/login']) ?>">Đăng nhập</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['site/signup']) ?>">Đăng ký</a></li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Tài khoản (<?= Html::encode(Yii::$app->user->identity->username) ?>)
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                    <li><?= Html::a('Hồ sơ', ['/site/profile'], ['class' => 'dropdown-item']) ?></li>
                                    <li><?= Html::a('Đổi mật khẩu', ['/site/change-password'], ['class' => 'dropdown-item']) ?></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><?= Html::a('Đăng xuất', ['/site/logout'], ['class' => 'dropdown-item', 'data-method' => 'post']) ?></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 0): ?>
                            <li class="nav-item"><a class="nav-link" href="http://localhost:8000/" target="_blank">Admin</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- CONTENT -->
        <main class="container mb-5">
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
            <?= $content ?>

        </main>

        <!-- FOOTER -->
        <!-- <footer class="bg-dark text-white text-center py-4 bottom-0% footer">
            <p>&copy; <?= date('Y') ?> Rau Củ Online. CTD.</p>
            <p>
                <a href="/site/about" class="text-white me-3">Về chúng tôi</a>
                <a href="/site/contact" class="text-white">Liên hệ</a>
            </p>
        </footer> -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <?php $this->endBody() ?>


        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg border-0">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Thông báo</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <h4 class="text-success mb-3">🎉 Đăng ký thành công!</h4>
                            <p>Bạn có thể đăng nhập để trải nghiệm hệ thống ngay.</p>
                        </div>
                        <div class="modal-footer">
                            <a href="<?= \yii\helpers\Url::to(['site/login']) ?>" class="btn btn-success">Đăng nhập</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            </script>
        <?php endif; ?>


        <?php
        $csrfToken = Yii::$app->request->getCsrfToken();
        $addToCartUrl = \yii\helpers\Url::to(['site/add-to-cart']);
        $this->registerJs("
    window.csrfToken = '{$csrfToken}';
    window.addToCartUrl = '{$addToCartUrl}';
    ", \yii\web\View::POS_HEAD);

        $this->registerJsFile('@web/js/cart.js', ['depends' => [\yii\web\JqueryAsset::class]]);
        ?>
    </div>
</body>

</html>
<?php $this->endPage() ?>