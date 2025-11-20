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
    <div class="container my-3">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            // Dòng chính chia cột linh hoạt theo kích thước màn hình
            'options' => ['class' => 'row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3'],
            // Mỗi sản phẩm là 1 cột
            'itemOptions' => ['class' => 'col'],
            'itemView' => function ($model) {
                $priceSaleValue = (float)$model->price * (100 - $model->discount) / 100;
                $priceSale = Yii::$app->formatter->asDecimal($priceSaleValue, 0) . '₫';
                $priceOrigin = Yii::$app->formatter->asDecimal($model->price, 0) . '₫';
                $url = Url::to(['site/product-detail', 'id' => $model->id]);
                $unit = Html::encode($model->unit);
                $img = Html::encode($model->image);
                $name = Html::encode($model->name);
                $urlImage = Url::to(['site/image', 'filename' => $img]);

                $discountHtml = $model->discount > 0
                    ? '<div class="d-flex justify-content-center align-items-center mt-1 gap-1">
                        <span class="text-muted text-decoration-line-through" style="font-size:12px;">' . $priceOrigin . '</span>
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">-' . $model->discount . '%</span>
                        </div>'
                    : '';

                $btn = $model->stock > 0
                    ? '<button class="btn btn-success w-100 rounded-pill fw-medium py-2 mt-2">
                        <i class="bi bi-cart-plus"></i> Mua
                   </button>'
                    : '<div class="text-center text-muted fw-bold text-uppercase mt-3">Hết hàng</div>';

                return '
            <div class="card border-0 shadow-sm h-100 product-card">
                <a href="' . $url . '" class="text-decoration-none text-dark">
                    <div class="image-box p-3">
                        <img  src="' . $urlImage . ' " class="card-img-top" alt="' . $name . '">
                    </div>
                    <div class="card-body p-2 text-center">
                        <h6 class="card-title text-truncate mb-1 fw-semibold" style="font-size:15px;">' . $name . '</h6>
                        <div class="text-danger fw-bold fs-6">' . $priceSale . ' 
                        <small class="text-muted">/' . $unit . '</small>
                        </div> 
                        ' . $discountHtml . '
                    </div>
                </a>
                <div class="px-2 pb-3 mt-auto">' . $btn . '</div>
            </div>';
            },
            'layout' => "{items}\n<div class='col-12 mt-3'>{pager}</div>",
        ]); ?>
    </div>


</div>