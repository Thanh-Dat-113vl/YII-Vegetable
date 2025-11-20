<?php

namespace backend\modules\admin\controllers;

use yii\web\Controller;
use common\models\Orders;
use common\models\Product;
use common\models\User;
use common\models\Review;
use yii\db\Expression;


class DashboardController extends Controller
{

    public function actionIndex()
    {
        $totalOrders = Orders::find()->count();
        $pendingOrders    = Orders::find()->where(['status' => 'pending'])->count();
        $shippingOrders   = Orders::find()->where(['status' => 'shipping'])->count();
        $completedOrders  = Orders::find()->where(['status' => 'completed'])->count();
        $canceledOrders   = Orders::find()->where(['status' => 'canceled'])->count();

        $totalProducts    = Product::find()->count();
        $totalUsers       = User::find()->count();

        $totalRevenue = Orders::find()
            ->where(['status' => 'completed'])
            ->sum('total_price');


        // ==========================
        // Đếm đơn hàng theo tháng
        // ==========================
        $monthlyOrders = (new \yii\db\Query())
            ->select([
                'month' => new Expression('MONTH(created_at)'),
                'count' => new Expression('COUNT(*)')
            ])
            ->from('orders')
            ->groupBy(new Expression('MONTH(created_at)'))
            ->orderBy('month')
            ->all();

        // Convert to array 12 months
        $monthlyData = array_fill(1, 12, 0);
        foreach ($monthlyOrders as $row) {
            $monthlyData[(int)$row['month']] = (int)$row['count'];
        }

        // ==========================
        // Đếm đơn hàng theo ngày (30 ngày gần nhất)
        // ==========================
        $dailyOrders = (new \yii\db\Query())
            ->select([
                'date'  => new Expression('DATE(created_at)'),
                'count' => new Expression('COUNT(*)')
            ])
            ->from('orders')
            ->where(['>=', 'created_at', new Expression('DATE_SUB(CURDATE(), INTERVAL 30 DAY)')])
            ->groupBy(new Expression('DATE(created_at)'))
            ->orderBy('date')
            ->all();

        $dailyLabels = [];
        $dailyCounts = [];

        foreach ($dailyOrders as $row) {
            $dailyLabels[] = $row['date'];
            $dailyCounts[] = (int)$row['count'];
        }

        return $this->render('index', [
            'totalOrders'     => $totalOrders,
            'pendingOrders'   => $pendingOrders,
            'shippingOrders'  => $shippingOrders,
            'completedOrders' => $completedOrders,
            'canceledOrders'  => $canceledOrders,

            'totalProducts'   => $totalProducts,
            'totalUsers'      => $totalUsers,
            'totalRevenue'    => $totalRevenue,

            'monthlyData'  => $monthlyData,
            'dailyLabels'  => $dailyLabels,
            'dailyCounts'  => $dailyCounts,
        ]);
    }
}
