<?php

use yii\helpers\Html;
?>

<div class="container-fluid">

    <h3 class="mb-4">Dashboard</h3>

    <div class="row">

        <!-- Tổng đơn hàng -->
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Orders</h5>
                    <h3><?= $totalOrders ?></h3>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5>Pending Orders</h5>
                    <h3><?= $pendingOrders ?></h3>
                </div>
            </div>
        </div>

        <!-- Shipping -->
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-dark shadow">
                <div class="card-body">
                    <h5>Shipping</h5>
                    <h3><?= $shippingOrders ?></h3>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Completed</h5>
                    <h3><?= $completedOrders ?></h3>
                </div>
            </div>
        </div>

        <!-- Canceled -->
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5>Canceled</h5>
                    <h3><?= $canceledOrders ?></h3>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h3><?= number_format($totalRevenue, 0) ?> VND</h3>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h3><?= $totalUsers ?></h3>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h5>Total Products</h5>
                    <h3><?= $totalProducts ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <canvas id="ordersChart" style=" height: 200px; margin: auto;"></canvas>

        </div>

        <div class="row mt-4">

            <!-- Biểu đồ cột theo tháng -->
            <div class="col-md-6 m-auto">
                <h5 class="mb-3">Thống kê đơn hàng theo tháng</h5>
                <div style="width:100%; height: 300px;">
                    <canvas id="chartMonthly"></canvas>
                </div>
            </div>

            <!-- Biểu đồ cột theo ngày -->
            <div class="col-md-6 m-auto">
                <h5 class="mb-3">Thống kê đơn hàng 30 ngày gần nhất</h5>
                <div style="width:100%; height: 300px;">
                    <canvas id="chartDaily"></canvas>
                </div>
            </div>

        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('ordersChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pending', 'Shipping', 'Completed', 'Canceled'],
                datasets: [{
                    data: [<?= $pendingOrders ?>, <?= $shippingOrders ?>, <?= $completedOrders ?>, <?= $canceledOrders ?>],
                    backgroundColor: ['#ffc107', '#0dcaf0', '#198754', '#dc3545']
                }]
            }
        });

        // ========================
        // Biểu đồ cột theo tháng
        // ========================
        var ctx1 = document.getElementById('chartMonthly').getContext('2d');
        var chartMonthly = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Số đơn hàng',
                    data: <?= json_encode(array_values($monthlyData)) ?>,
                    backgroundColor: '#0d6efd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });


        // Biểu đồ theo ngày
        var ctx2 = document.getElementById('chartDaily').getContext('2d');
        var chartDaily = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?= json_encode($dailyLabels) ?>,
                datasets: [{
                    label: 'Đơn hàng',
                    data: <?= json_encode($dailyCounts) ?>,
                    backgroundColor: '#198754'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>


</div>