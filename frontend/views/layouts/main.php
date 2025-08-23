<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?> | Rau Củ Online</title>
    <?php $this->head() ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🥦 VEGETABLE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><?= Html::a('Trang chủ', ['/site/index'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= Html::a('Sản phẩm', ['site/product'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= Html::a('Giỏ hàng', ['site/Cart'], ['class' => 'nav-link']) ?></li>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li class="nav-item"><?= Html::a('Đăng nhập', ['/site/login'], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= Html::a('Đăng ký', ['/site/signup'], ['class' => 'nav-link']) ?></li>
                    <?php else: ?>
                        <li class="nav-item"><?= Html::a('Tài khoản (' . Yii::$app->user->identity->username . ')', ['/site/profile'], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= Html::a('Đăng xuất', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- BANNER -->
    <?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'): ?>
        <div class="bg-success text-white text-center py-5 mb-4" style="background: url('/images/banner.jpg') center/cover no-repeat; min-height: 300px;">
            <div class="bg-dark bg-opacity-50 p-5">
                <h1 class="display-4 fw-bold">Chào mừng đến Rau Củ Online</h1>
                <p class="lead">Nơi cung cấp rau củ sạch, tươi ngon mỗi ngày 🥕🥬</p>
                <a href="/product/index" class="btn btn-warning btn-lg">Mua ngay</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- CONTENT -->
    <main class="container mb-5">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        <?= $content ?>
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; <?= date('Y') ?> Rau Củ Online. All rights reserved.</p>
        <p>
            <a href="/site/about" class="text-white me-3">Về chúng tôi</a>
            <a href="/site/contact" class="text-white">Liên hệ</a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>