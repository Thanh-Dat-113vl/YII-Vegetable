<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Lịch sử mua hàng";
?>

<div class="">
    <div class="d-flex border-top border-bottom bg-light "
        style="border-color:#f2f5f9; border-width:2px 0; height:46px;">
        <button class="btn btn-link text-dark" style="width:46px;" onclick="window.history.back();">
            <i class="bi bi-chevron-left"></i> </button>
        <div class="flex-grow-1 d-flex align-items-center pt-3">
            <a class="text-decoration-none text-dark text-center">
                <h4 class="fw-bold mb-4"><i class="bi bi-clock-history me-2"></i>Lịch sử mua hàng</h4>
            </a>
        </div>
    </div>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'mb-4'],
        'emptyText' => '<div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>',
        'layout' => "{items}\n<div class='col-12 mt-3'>{pager}</div>",
        'itemView' => function ($order) {
            $total = Yii::$app->formatter->asCurrency($order->total_price, 'VND');
            $map = [
                'pending' => 'Đang xử lý',
                'confirmed' => 'Đã xác nhận',
                'completed' => 'Hoàn tất',
                'canceled' => 'Đã huỷ'
            ];
            $statusClass = [
                'pending' => 'badge bg-warning text-dark',
                'confirmed' => 'badge bg-info text-dark',
                'completed' => 'badge bg-success',
                'canceled' => 'badge bg-danger'
            ][$order->status] ?? 'badge bg-secondary';


            $itemsHtml = '';
            foreach ($order->items as $item) {
                $name = Html::encode($item->product->name ?? '');
                $img = Html::encode($item->product->image ?? '');
                $qty = $item->quantity;
                $price = Yii::$app->formatter->asDecimal($item->price, 0) . '₫';
                $itemsHtml .= "
                    <div class='d-flex align-items-center mb-2'>
                        <img src='/uploads/{$img}' class='me-2' style='width:50px;height:50px;object-fit:cover;border-radius:5px;'>
                        <div class='flex-grow-1'>
                            <div>{$name}</div>
                            <small class='text-muted'>SL: {$qty} × {$price}</small>
                        </div>
                    </div>
                ";
            }

            $viewUrl = Url::to(['site/order-detail', 'id' => $order->id]);

            return "
                <div class='card shadow-sm border-0 my-3'>
                    <div class='card-body'>
                        <div class='d-flex justify-content-between align-items-center mb-2'>
                            <h6 class='mb-0'>Đơn hàng #{$order->id}</h6>
                            <span class='{$statusClass}'> {$map[$order->status]}</span>

                        </div>
                        <div class='text-muted small mb-3'>Ngày đặt: " . Yii::$app->formatter->asDatetime($order->created_at) . "</div>
                        {$itemsHtml}
                        <hr>
                        <div class='d-flex justify-content-between align-items-center'>
                            <div><strong>Tổng tiền:</strong> {$total}</div>
                            <a href='{$viewUrl}' class='btn btn-outline-success btn-sm'>
                                <i class='bi bi-eye'></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            ";
        },
    ]); ?>
</div>