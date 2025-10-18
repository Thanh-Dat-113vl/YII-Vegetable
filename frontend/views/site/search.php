<?php
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $keyword string */
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
        'options' => ['class' => 'row g-3'], // bọc item trong row
        'itemOptions' => ['class' => 'col-lg-3 col-md-4 col-sm-6 d-flex'], 
        'itemView' => function ($model, $key, $index, $widget) {
            return '
            <div class="card product-card shadow-sm flex-fill h-100 border-0">
                <div class="position-relative">
                    <img src="/uploads/'.$model->image.'" 
                         class="card-img-top p-3" 
                         style="height:220px;object-fit:contain;" 
                         alt="'.$model->name.'">
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <h6 class="card-title text-truncate" title="'.$model->name.'"
                        style="font-size:14px; min-height:40px">'.$model->name.'</h6>
                    <p class="text-danger fw-bold mb-3">'.Yii::$app->formatter->asCurrency($model->price* (100 - $model->discount) / 100,'VND').'</p>
                    <button class="btn btn-success btn-sm mt-auto add-to-cart-btn"
                            data-id="'.$model->id.'" 
                            data-name="'.$model->name.'" 
                            data-price="'.$model->price.'" 
                            data-image="'.$model->image.'">
                        <i class="bi bi-cart-plus"></i> Mua ngay
                    </button>
                </div>
            </div>';
        },
        'layout' => "{items}\n<div class='col-12'>{pager}</div>",
    ]); ?>
        </div>
    </div>


</div>