<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\models\Banner;

$banners = Banner::find()->where(['status' => 1])->all();


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <?= Html::csrfMetaTags() ?>

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
                    <!-- <li class="nav-item"><?= Html::a('Trang chủ', ['/site/index'], ['class' => 'nav-link']) ?></li> -->
                    <li class="nav-item"><?= Html::a('Sản phẩm', ['site/product'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item">
                        <?= Html::a('<i class="bi bi-cart"></i>', ['site/cart'], [
                            'class' => 'nav-link',
                            'encode' => false,
                            'title' => 'Giỏ hàng',
                            'data-bs-toggle' => 'tooltip',
                        ]) ?>
                    </li>

                    </li> <?php if (Yii::$app->user->isGuest): ?>
                        <li class="nav-item"><?= Html::a('Đăng nhập', ['site/login'], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= Html::a('Đăng ký', ['site/signup'], ['class' => 'nav-link']) ?></li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tài khoản (<?= Yii::$app->user->identity->username ?>)
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <li><?= Html::a('Hồ sơ', ['/site/profile'], ['class' => 'dropdown-item']) ?></li>
                                <li><?= Html::a('Đổi mật khẩu', ['/site/change-password'], ['class' => 'dropdown-item']) ?></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><?= Html::a('Đăng xuất', ['/site/logout'], ['class' => 'dropdown-item', 'data-method' => 'post']) ?></li>
                            </ul>
                        </li>

                    <?php endif; ?>

                    <!--DK user đăng nhập là admin thì hiện link admin -->
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 0): ?>
                        <li class="nav-item">
                            <?= Html::a('Admin', 'http://localhost:8080/', ['class' => 'nav-link', 'target' => '_blank']) ?>
                        </li>
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