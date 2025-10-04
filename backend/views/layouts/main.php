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
                <li class="nav-item"><a href="/admin/category/index" class="nav-link text-white" <i class="bi bi-folder"></i> Category</a></li>
                <li class="nav-item"><a href="/admin/product/index" class="nav-link text-white" <i class="bi bi-box"></i> Product</a></li>
                <li class="nav-item"><a href="/admin/users/index" class="nav-link text-white" <i class="bi bi-people"></i> User</a></li>
                <li class="nav-item"><a href="/admin/dashboard/index" class="nav-link text-white" <i class="bi bi-house"></i>Dashboard</a></li>
            </ul>
        </div>

        <!-- Content -->
        <div class="flex-grow-1 p-4">
            <?= $content ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>