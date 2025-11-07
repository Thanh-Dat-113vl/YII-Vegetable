<?php

use yii\helpers\Html;
use yii\helpers\Url;

$updateUrl = Url::to(['site/update-quantity']);
$this->registerJs("var updateUrl = '$updateUrl';", \yii\web\View::POS_HEAD);


$this->title = 'Giỏ hàng';
$total = 0;
$ship = 15000;
?>

<div class="container py-4 bg-white">
    <?php if (!empty($cart)): ?>
        <button class="btn btn-link text-dark" style="width:46px;" onclick="window.history.back();">
            <i class="bi bi-chevron-left"></i> </button>
        <h3 class="mb-3 fw-bold text-center"><?= Html::encode($this->title) ?></h3>

        <!-- Tabs giao hàng -->
        <form action="<?= Url::to(['cart/checkout']) ?>" method="post">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

            <input type="hidden" name="delivery_type" id="delivery_type" value="delivery">

            <ul class="nav nav-pills mb-3" id="deliveryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="ship-tab" data-bs-toggle="pill" data-bs-target="#ship" type="button"
                        role="tab" value="delivery">
                        Giao hàng tận nơi
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="store-tab" data-bs-toggle="pill" data-bs-target="#store" type="button"
                        role="tab" value="store">
                        Nhận tại cửa hàng
                    </button>
                </li>
            </ul>
            <!-- đọc delivery type -->
            <script>
                document.querySelectorAll('#deliveryTabs button').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.getElementById('delivery_type').value = btn.value;
                    });
                });
            </script>

            <div class="tab-content mb-4" id="deliveryTabsContent">
                <!-- Tab 1: Giao hàng tận nơi -->
                <div class="tab-pane fade show active" id="ship" role="tabpanel">
                    <div class="row g-3 m-3">
                        <div id="address-field" class="mb-3">
                            <label>Địa chỉ giao hàng</label>
                            <input type="text" name="address" class="form-control mt-2" placeholder="Nhập địa chỉ nhận hàng...">
                        </div>
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
                            <input type="text" class="form-control" placeholder="Nhập tên người nhận"
                                value="<?= $user ? Html::encode($user->fullname ?? $user->username) : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Số điện thoại</label>
                            <input type="text" class="form-control" placeholder="Nhập số điện thoại"
                                value="<?= $user ? Html::encode($user->phone ?? '') : '' ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Phí giao hàng</label>
                            <input type="text" class="form-control" value="15.000đ" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Hình thức thanh toán</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="payment-cod" value="cod" checked>
                                <label class="form-check-label" for="payment-cod">Tiền mặt khi nhận hàng (COD)</label>
                            </div>
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="radio" name="payment" id="payment-bank" value="bank">
                                <label class="form-check-label" for="payment-bank">Chuyển khoản</label>
                            </div>

                            <!-- Thông tin chuyển khoản hiện khi chọn 'bank' -->
                            <div id="bank-info" class="mt-2 small text-muted d-none">
                                <div>Ngân hàng: <strong>Ngân hàng ABC</strong></div>
                                <div>Chủ TK: <strong>Công ty VEGETABLE</strong></div>
                                <div>Số TK: <strong>0123456789</strong></div>
                                <div class="form-text">Ghi chú chuyển khoản: <strong>ORDER-{order_code}</strong></div>
                            </div>
                            <script>
                                (function() {
                                    var els = document.querySelectorAll('input[name=\"payment\"]');

                                    function updateBankInfo() {
                                        var sel = document.querySelector('input[name=\"payment\"]:checked');
                                        var el = document.getElementById('bank-info');
                                        if (sel && sel.value === 'bank') el.classList.remove('d-none');
                                        else el.classList.add('d-none');
                                    }
                                    els.forEach(function(i) {
                                        i.addEventListener('change', updateBankInfo);
                                    });
                                    updateBankInfo();
                                })();
                            </script>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Nhận tại cửa hàng -->

                <div class="tab-pane fade mt-2 p-2" id="store" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Chọn cửa hàng nhận hàng</label>
                            <select class="form-select" name="store_name">
                                <option value="BHX Thủ Đức (Ngã 4 Bình Thái)">BHX Thủ Đức (Ngã 4 Bình Thái)</option>
                                <option value="BHX Quận 9 (Đỗ Xuân Hợp)">BHX Quận 9 (Đỗ Xuân Hợp)</option>
                                <option value="BHX Quận 7 (Huỳnh Tấn Phát)">BHX Quận 7 (Huỳnh Tấn Phát)</option>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- Danh sách sản phẩm -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white fw-bold">
                        Đơn hàng của bạn
                    </div>
                    <div class="card-body p-0">
                        <table class="table align-middle mb-0">
                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <?php
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                    ?>
                                    <tr>
                                        <td style="width:80px;">
                                            <img src="<?= Yii::getAlias('@web/uploads/' . Html::encode($item['image'])) ?>" width="70"
                                                class="rounded">

                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?= Html::encode($item['name']) ?></div>
                                            <div class="text-muted small">
                                                Giá: <?= number_format($item['price'], 0, ',', '.') ?>đ
                                            </div>
                                            <a href="#" class="text-danger small remove-item" data-id="<?= $item['id'] ?>">
                                                Xóa
                                            </a>
                                        </td>
                                        <td class="text-end ">
                                            <div class="input-group input-group-sm justify-content-end" style="max-width:110px;">
                                                <button class="btn btn-outline-secondary btn-minus" type="button"
                                                    data-id="<?= $item['id'] ?>">−</button>
                                                <input type="text" class="form-control text-center quantity-input"
                                                    value="<?= $item['quantity'] ?>" readonly>
                                                <button class="btn btn-outline-secondary btn-plus" type="button"
                                                    data-id="<?= $item['id'] ?>">＋</button>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold subtotal" data-price="<?= $item['price'] ?>">
                                            <?= number_format($subtotal, 0, ',', '.') ?>đ
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- Tổng tiền & Đặt hàng -->
                <div class="d-flex justify-content-between align-items-center bg-light border-top py-3 px-4">
                    <div class="fw-bold fs-5 text-success">
                        Tổng cộng:
                        <span id="cart-total"><?= number_format($total, 0, ',', '.') ?>đ</span>
                    </div>
                    <!-- <button class="btn btn-success px-5 py-2 fw-bold text-uppercase">
                    <i class="bi bi-cart-check"></i> Đặt hàng
                </button> -->
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold text-uppercase">
                        <i class="bi bi-cart-check"></i> Đặt hàng
                    </button>
                </div>
        </form>
    <?php else: ?>
        <div class="container py-2">
            <div class="d-flex align-items-center mb-3">
                <button class="btn btn-link text-dark p-0 me-2" style="width:46px;" onclick="window.history.back();">
                    <i class="bi bi-chevron-left fs-5"></i>
                </button>
                <h5 class="flex-grow-1 text-center m-0 fw-semibold">Giỏ hàng của Bạn</h5>
                <div style="width:46px;"></div>
            </div>

            <div class="text-center mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="currentColor"
                    class="bi bi-cart4 text-success mb-3" viewBox="0 0 16 16">
                    <path
                        d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                </svg>

                <div>
                    <a href="/" class="btn btn-success px-4 mb-2">Tiếp tục mua hàng</a>
                    <p class="text-muted mb-0">Vẫn còn 10.000+ sản phẩm đang chờ</p>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>


<?php
$removeUrl = Url::to(['cart/remove-from-cart']);
$updateUrl = Url::to(['cart/update-quantity']);

$js = <<<JS
// Xóa sản phẩm khỏi giỏ hàng
$(document).on('click', '.remove-item', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    if (!id) return;

    if (!confirm("Bạn có chắc muốn xóa sản phẩm này?")) return;

    $.post('$removeUrl', { id: id }, function(res) {
        if (res.success) {
            alert("🗑️ Đã xóa sản phẩm khỏi giỏ hàng!");
            location.reload();
        } else {
            alert("❌ " + res.message);
        }
        updateCartBadge(res.cartCount);
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
function updateTotal(ship = 15000) {
    let subtotal = parseInt($('#subtotal').text().replace(/\\D/g, ''));
    let total = subtotal + ship;
    $('#total').text(total.toLocaleString('vi-VN') + ' đ');
}

// // Google Map
// let map, marker, geocoder;

// function initMap() {
//     geocoder = new google.maps.Geocoder();
//     map = new google.maps.Map(document.getElementById("map"), {
//         center: { lat: 10.762622, lng: 106.660172 },
//         zoom: 13
//     });

//     const input = document.getElementById("address-input");
//     const autocomplete = new google.maps.places.Autocomplete(input);
//     autocomplete.bindTo("bounds", map);

//     autocomplete.addListener("place_changed", function() {
//         const place = autocomplete.getPlace();
//         if (!place.geometry) return;

//         map.setCenter(place.geometry.location);
//         map.setZoom(15);

//         if (marker) marker.setMap(null);
//         marker = new google.maps.Marker({
//             position: place.geometry.location,
//             map: map
//         });

//         // Giả lập tính phí ship theo khoảng cách 
//         const store = { lat: 10.762622, lng: 106.660172 }; // cửa hàng tại Q1
//         const user = place.geometry.location;
//         const distance = google.maps.geometry.spherical.computeDistanceBetween(
//             new google.maps.LatLng(store),
//             new google.maps.LatLng(user)
//         );

//         let fee = 0;
//         if (distance <= 2000) fee = 0; // <= 2km free
//         else if (distance <= 5000) fee = 15000; // <= 5km
//         else if (distance <= 10000) fee = 30000; // <= 10km
//         else fee = 50000; // xa hơn

//         $('#shipping').text(fee.toLocaleString('vi-VN') + ' đ');
//         updateTotal(fee);
//     });
// }
//+ - số luong

$(document).on('click', '.btn-plus, .btn-minus', function(e) {
     e.preventDefault();
    const id = $(this).data('id');
    const type = $(this).hasClass('btn-plus') ? 'plus' : 'minus';
    const row = $(this).closest('tr');

    const quantityInput = $(this).closest('.input-group').find('.quantity-input');
    const subtotalCell = $(this).closest('tr').find('.subtotal');
    const totalText = $('#cart-total');
    const currentQty = parseInt(quantityInput.val());


     if (type === 'minus' && currentQty === 1) {
        if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng không?')) {
            return; 
        }
    }
    
    $.post('$updateUrl', {id, type}, function(res) {
        if (res.success) {
            if (res.quantity > 0) {
                quantityInput.val(res.quantity);
                subtotalCell.text(
                    (res.quantity * parseFloat(subtotalCell.data('price'))).toLocaleString('vi-VN') + 'đ'
                );
            } else {
                    $(quantityInput).closest('tr').fadeOut(300, function() {
                    $(this).remove();
                });            
            }

            totalText.text(res.total + 'đ');
            updateCartBadge(res.cartCount); // 🔹 cập nhật badge
        }
    });
});
JS;
$this->registerJs($js);
?>

<!-- Google Maps API -->
<script async src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places,geometry&callback=initMap">
</script>