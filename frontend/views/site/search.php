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
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
            <!-- g-3 tạo khoảng cách giữa các card -->
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'row g-3'],
                // 'itemOptions' => ['class' => 'col-lg-3 custom-width'],
                'itemOptions' => ['tag' => false],

                'itemView' => function ($model, $key, $index, $widget) {
                    $priceSaleValue = (float)$model->price * (100 - $model->discount) / 100;
                    $priceSale = Yii::$app->formatter->asDecimal($priceSaleValue, 0) . '₫';
                    $priceOrigin = Yii::$app->formatter->asDecimal($model->price, 0) . '₫';
                    $url = Url::to(['site/product-detail', 'id' => $model->id]);
                    $unit = $model->unit;
                    $img = Html::encode($model->image);
                    $name = Html::encode($model->name);

                    $stockButton = $model->stock > 0
                        ? '<button class="add-to-cart-btn btn btn-success rounded-pill w-100 fw-medium py-2 mt-2">
               <i class="bi bi-cart-plus"></i> Mua
           </button>'
                        : '<div class="text-center text-muted fw-bold text-uppercase fs-6 mt-3">Hết hàng</div>';

                    $priceDiscount = $model->discount > 0
                        ? '<div class="d-flex justify-content-center align-items-center">
                        <span class="text-muted text-decoration-line-through me-2" style="font-size:12px;">' . $priceOrigin . '</span>
                        <span class="badge bg-danger text-white fw-bold">-' . $model->discount . ''
                        . '%</span>
                    </div>'
                        : '';

                    return '
    <div class="col d-flex">
        <div class="card product-card shadow-sm w-100 d-flex flex-column">

         <a href="' . $url . '" class="text-decoration-none text-dark">
                          <img src="/uploads/' . $img . '" alt="' . $name . '"  class="card-img-top" style="height:180px;object-fit:contain;" alt="<?= Html::encode($name) ?>">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-truncate mb-2" title="<?= Html::encode($name) ?>" style="font-size:16px; min-height:40px; font-weight:600;">' . $name . '</h6>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class=" fw-bold " style="font-size:15px;">
                                       ' . $priceSaleValue . '₫
                                        <small class="text-muted">/' . $unit . '</small>
                                    </div>
                                </div>
                                ' . $priceDiscount . '
                            </div>
                        </a>
                ' . $stockButton . '
                        </div>
                    </div>';
                },

                'layout' => "{items}\n<div class='col-12'>{pager}</div>",
            ]); ?>
        </div>
    </div>
</div>