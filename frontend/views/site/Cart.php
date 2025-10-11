<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Giỏ hàng';
$total = 0;
?>

<div class="container py-4 bg-white">
    <h3 class="mb-3 fw-bold"><?= Html::encode($this->title) ?></h3>

    <!-- Tabs giao hàng -->
    <ul class="nav nav-pills mb-3" id="deliveryTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ship-tab" data-bs-toggle="pill"
                data-bs-target="#ship" type="button" role="tab">
                Giao hàng tận nơi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="store-tab" data-bs-toggle="pill"
                data-bs-target="#store" type="button" role="tab">
                Nhận tại cửa hàng
            </button>
        </li>
    </ul>

    <div class="tab-content mb-4" id="deliveryTabsContent">
        <!-- Tab 1: Giao hàng tận nơi -->
        <div class="tab-pane fade show active" id="ship" role="tabpanel">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Giới tính</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" checked>
                        <label class="form-check-label" for="male">Anh</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female">
                        <label class="form-check-label" for="female">Chị</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tên người nhận</label>
                    <input type="text" class="form-control"
                        placeholder="Nhập tên người nhận"
                        value="<?= $user ? Html::encode($user->fullname ?? $user->username) : '' ?>" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Số điện thoại</label>
                    <input type="text" class="form-control"
                        placeholder="Nhập số điện thoại"
                        value="<?= $user ? Html::encode($user->phone ?? '') : '' ?>" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Phí giao hàng</label>
                    <input type="text" class="form-control" value="15.000đ" readonly>
                </div>
            </div>
        </div>

        <!-- Tab 2: Nhận tại cửa hàng -->
        <div class="tab-pane fade" id="store" role="tabpanel">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Chọn cửa hàng nhận hàng</label>
                    <select class="form-select">
                        <option>BHX Thủ Đức (Ngã 4 Bình Thái)</option>
                        <option>BHX Quận 9 (Đỗ Xuân Hợp)</option>
                        <option>BHX Quận 7 (Huỳnh Tấn Phát)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white fw-bold">
            Đơn hàng của bạn
        </div>
        <div class="card-body p-0">
            <?php if (!empty($cart)): ?>
                <table class="table align-middle mb-0">
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <?php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td style="width:80px;">
                                    <img src="<?= Url::to('@web/uploads/' . Html::encode($item['image'])) ?>"
                                        width="70" class="rounded">
                                </td>
                                <td>
                                    <div class="fw-semibold"><?= Html::encode($item['name']) ?></div>
                                    <div class="text-muted small">
                                        Giá: <?= number_format($item['price'], 0, ',', '.') ?>đ
                                    </div>
                                    <a href="#" class="text-danger small">Xóa</a>
                                </td>
                                <td class="text-end ">
                                    <div class="input-group input-group-sm justify-content-end" style="max-width:110px;">
                                        <button class="btn btn-outline-secondary btn-minus" data-id="<?= $item['id'] ?>"> − </button>
                                        <input type="text" class="form-control text-center" value="<?= $item['quantity'] ?>" readonly>
                                        <button class="btn btn-outline-secondary btn-plus" data-id="<?= $item['id'] ?>"> + </button>
                                    </div>
                                </td>
                                <td class="text-end fw-bold">
                                    <?= number_format($subtotal, 0, ',', '.') ?>đ
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="p-3 text-center text-muted">Giỏ hàng trống</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tổng tiền & Đặt hàng -->
    <div class="d-flex justify-content-between align-items-center bg-light border-top py-3 px-4">
        <div class="fw-bold fs-5 text-success">
            Tổng cộng:
            <span id="cart-total"><?= number_format($total, 0, ',', '.') ?>đ</span>
        </div>
        <button class="btn btn-success px-5 py-2 fw-bold text-uppercase">
            <i class="bi bi-cart-check"></i> Đặt hàng
        </button>
    </div>
</div>


<?php
$removeUrl = Url::to(['site/remove-from-cart']);
$js = <<<JS
// Xóa sản phẩm
$('.remove-item').on('click', function() {
    const id = $(this).data('id');
    $.post('$removeUrl', {id}, function(res) {
        if (res.success) location.reload();
    });
});

// Toggle giao hàng
$('input[name="delivery_type"]').on('change', function() {
    const val = $(this).val();
    if (val === 'delivery') {
        $('#address-section').removeClass('d-none');
    } else {
        $('#address-section').addClass('d-none');
        $('#shipping').text('0 đ');
        updateTotal();
    }
});

// Cập nhật tổng
function updateTotal(ship = 0) {
    let subtotal = parseInt($('#subtotal').text().replace(/\\D/g, ''));
    let total = subtotal + ship;
    $('#total').text(total.toLocaleString('vi-VN') + ' đ');
}

// Google Map
let map, marker, geocoder;

function initMap() {
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 10.762622, lng: 106.660172 },
        zoom: 13
    });

    const input = document.getElementById("address-input");
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", function() {
        const place = autocomplete.getPlace();
        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        map.setZoom(15);

        if (marker) marker.setMap(null);
        marker = new google.maps.Marker({
            position: place.geometry.location,
            map: map
        });

        // Giả lập tính phí ship theo khoảng cách (BHX-style)
        const store = { lat: 10.762622, lng: 106.660172 }; // cửa hàng tại Q1
        const user = place.geometry.location;
        const distance = google.maps.geometry.spherical.computeDistanceBetween(
            new google.maps.LatLng(store),
            new google.maps.LatLng(user)
        );

        let fee = 0;
        if (distance <= 2000) fee = 0; // <= 2km free
        else if (distance <= 5000) fee = 15000; // <= 5km
        else if (distance <= 10000) fee = 30000; // <= 10km
        else fee = 50000; // xa hơn

        $('#shipping').text(fee.toLocaleString('vi-VN') + ' đ');
        updateTotal(fee);
    });
}
JS;
$this->registerJs($js);
?>

<!-- Google Maps API -->
<script async
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places,geometry&callback=initMap">
</script>