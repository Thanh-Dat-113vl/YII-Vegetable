<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Thông tin cá nhân";
?>
<div class="bg-light" style="min-height:100vh;">
    <!-- HEADER -->
    <div class="d-flex align-items-center border-bottom bg-white shadow-sm"
        style="height:50px;">
        <button class="btn btn-link text-dark px-3" onclick="window.history.back();">
            <i class="bi bi-chevron-left fs-5"></i>
        </button>
        <div class="flex-grow-1 text-center pe-5">
            <h3 class="fs-6 mb-0 fw-semibold">Sửa thông tin cá nhân</h3>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="container d-flex justify-content-center mt-4">
        <div class="bg-white p-4 shadow rounded-4"
            style="max-width: 500px; width: 100%;">

            <h5 class="text-center mb-4 fw-semibold">Thông tin cá nhân</h5>

            <form action="<?= Url::to(['/site/profile', 'id' => $user->id]) ?>" method="post">
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <div class="mb-3">
                    <label class="form-label fw-medium">Tên đăng nhập</label>
                    <input type="text" class="form-control form-control-lg"
                        name="User[username]"
                        value="<?= Html::encode($user->username) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Email</label>
                    <input type="email" class="form-control form-control-lg"
                        name="User[email]"
                        value="<?= Html::encode($user->email) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Số điện thoại</label>
                    <input type="text" class="form-control form-control-lg"
                        name="User[phone]"
                        value="<?= Html::encode($user->phone) ?>" readonly>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 mt-3 rounded-3">
                    Cập nhật thông tin
                </button>

            </form>
        </div>
    </div>
</div>