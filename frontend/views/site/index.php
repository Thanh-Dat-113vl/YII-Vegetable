<?php
$this->title = "Trang chủ";
?>

<!-- BANNER -->
<div id="mainBanner" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <a href="#">
                <div class="d-flex align-items-center justify-content-center text-white text-center"
                    style="background: url('/images/banner1.jpg') center/cover no-repeat; min-height: 300px;">
                    <div class="bg-dark bg-opacity-50 p-5 rounded">
                        <h1 class="display-5 fw-bold">CTD - Banner 1</h1>
                        <p class="lead">Thông điệp banner số 1</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <a href="#">
                <div class="d-flex align-items-center justify-content-center text-white text-center"
                    style="background: url('/images/banner2.jpg') center/cover no-repeat; min-height: 300px;">
                    <div class="bg-dark bg-opacity-50 p-5 rounded">
                        <h1 class="display-5 fw-bold">CTD - Banner 2</h1>
                        <p class="lead">Thông điệp banner số 2</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Nút điều khiển -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        <!-- Chấm tròn điều hướng -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="2"></button>
        </div>
    </div>


    <div class="row text-center mb-5">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h3>🥬 Rau sạch</h3>
                <p>Tươi ngon từ nông trại Việt Nam</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h3>🥕 Củ quả tươi</h3>
                <p>Bảo quản tốt, giữ trọn dinh dưỡng</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h3>🍎 Trái cây</h3>
                <p>Ngọt lành từ vườn cây an toàn</p>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Sản phẩm nổi bật</h2>
    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4">

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/rau.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Rau</h5>
                        <p class="text-success fw-bold">100 VNĐ</p>
                        <div class="mb-2 text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span class="text-muted ms-2">(12 đánh giá)</span>
                        </div>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/cai.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Cải</h5>
                        <p class="text-success fw-bold">1500 VNĐ</p>
                        <div class="mb-2 text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <span class="text-muted ms-2">(12 đánh giá)</span>
                        </div>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>

                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/cai.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Cải</h5>
                        <p class="text-success fw-bold">1500 VNĐ</p>
                        <div class="mb-2 text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span class="text-muted ms-2">(12 đánh giá)</span>
                        </div>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/cai.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Cải</h5>
                        <p class="text-success fw-bold">1500 VNĐ</p>
                        <div class="mb-2 text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span class="text-muted ms-2">(12 đánh giá)</span>
                        </div>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/cai.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Cải</h5>
                        <p class="text-success fw-bold">1500 VNĐ</p>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/cai.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Cải</h5>
                        <p class="text-success fw-bold">1500 VNĐ</p>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/cai.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Cải</h5>
                        <p class="text-success fw-bold">1500 VNĐ</p>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="images/cai.jpg" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5>Cải</h5>
                        <p class="text-success fw-bold">1500 VNĐ</p>
                        <a href="#" class="btn btn-outline-success mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>


        </div>
    </div>