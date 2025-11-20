<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3 min-vh-100" style="width:220px;">
            <h4 class="mb-4 nav-item"> <a href="/admin" class="nav-link">Admin Panel </a></h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/admin/category/index" class="nav-link text-white"> <i class="bi bi-folder"></i> Category</a>
                </li>
                <li class="nav-item">
                    <a href="/admin/product/index" class="nav-link text-white">
                        <i class="bi bi-box"></i> Product
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/users/index" class="nav-link text-white">
                        <i class="bi bi-people"></i> User
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/orders/index" class="nav-link text-white">
                        <i class="bi bi-receipt"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/rating/index" class="nav-link text-white">
                        <i class="bi bi-stars"></i> Rating
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/dashboard/index" class="nav-link text-white border-2 border-top ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                            <path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z" />
                            <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0" />
                        </svg>
                        Dashboard
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="flex-grow-1 p-4">
            <?= $content ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>