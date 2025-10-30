<?php

use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $keyword string */

$this->title = "Tìm kiếm: " . Html::encode($keyword);

?>

<div class="" style="min-height:100vh ;margin-bottom:20px">
    <div class="d-flex border-top border-bottom bg-light "
        style="border-color:#f2f5f9; border-width:2px 0; height:46px;">
        <button class="btn btn-link text-dark" style="width:46px;" onclick="window.history.back();">
            <i class="bi bi-chevron-left"></i> </button>
        <div class="flex-grow-1 d-flex align-items-center ">
            <a class="text-decoration-none text-dark text-center">
                <h3 class="fs-6">Kết quả tìm kiếm: <em><?= htmlspecialchars($keyword) ?></em></h3>
            </a>
        </div>

    </div>
    <div class="container">
        <div class="row g-3">
            <!-- g-3 tạo khoảng cách giữa các card -->
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'row g-3'],
                // 'itemOptions' => ['class' => 'col-lg-3 custom-width'],
                'itemOptions' => ['class' => 'card '],

                'itemView' => function ($model, $key, $index, $widget) {
                    $priceSaleValue = $model->price * (100 - $model->discount) / 100;
                    $priceSale = Yii::$app->formatter->asDecimal($priceSaleValue, 0) . '₫';
                    $priceOrigin = Yii::$app->formatter->asDecimal($model->price, 0) . '₫';
                    $url = Url::to(['site/product-detail', 'id' => $model->id]);

                    $img = Html::encode($model->image);
                    $name = Html::encode($model->name);

                    // stars (simple)
                    $fullStars = floor($model->rating);
                    $halfStar  = ($model->rating - $fullStars >= 0.5) ? 1 : 0;
                    $emptyStars = 5 - $fullStars - $halfStar;
                    $starsHtml = str_repeat('<i class="fa fa-star"></i>', $fullStars);
                    if ($halfStar) $starsHtml .= '<i class="fa fa-star-half-o"></i>';
                    $starsHtml .= str_repeat('<i class="fa fa-star-o"></i>', $emptyStars);

                    $stockButton = $model->stock > 0
                        ? '<button type="button" class="add-to-cart-btn btn btn-outline-success mt-auto w-100" data-id="' . $model->id . '" data-name="' . $name . '" data-price="' . htmlspecialchars($priceSaleValue) . '" data-image="' . $img . '"><i class="bi bi-cart-plus"></i> Mua</button>'
                        : '<div class="text-center mt-auto text-body-tertiary text-bord text-uppercase fs-6">TẠM HẾT HÀNG</div>';

                    return '
                    <div class="card product-card shadow-sm flex-fill h-100 border-0 d-flex flex-column">
                        <a href="' . $url . '" class="text-decoration-none text-dark">
                            <div class="position-relative">
                                <img src="/uploads/' . $img . '" class="card-img-top p-3" style="height:220px;object-fit:contain;" alt="' . $name . '">
                            </div>
                            <div class="card-body d-flex flex-column text-center">
                                <h6 class="card-title text-truncate mb-2" title="' . $name . '" style="font-size:14px; min-height:40px; font-weight:600;">' . $name . '</h6>
                                <p class="text-danger fw-bold mb-1" style="font-size:16px;">' . $priceSale . '</p>
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <span class="text-decoration-line-through me-2" style="color:#9DA7BC; font-size:12px;">' . $priceOrigin . '</span>
                                    <span class="fw-bold text-white text-center d-inline-block" style="min-width:36px; border-radius:4px; background-color:rgba(255,1,1,0.8); padding:2px 6px; font-size:11px;">-' . $model->discount . '%</span>
                                </div>
                            </div>
                        </a>
                        <div class="px-3 pb-3 mt-auto">' . $stockButton . '</div>
                    </div>';
                },
                'layout' => "{items}\n<div class='col-12'>{pager}</div>",
            ]); ?>
        </div>
    </div>
</div>