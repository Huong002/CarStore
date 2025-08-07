<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    // thong ke tong hoa don
    public static function totalOrder()
    {
        return Order::count();
    }
    // thong ke tong doanh thu
    public static function totalRevenue()
    {
        return Order::sum('total');
    }


    // tong don hang da giao
    public static function orderCompleted()
    {
        return Order::where('status', 'completed')->count();
    }

    // don hang da xu li 
    public static function orderApproed()
    {
        return Order::where('status', 'approved')->count();
    }


    // don hang da huy
    public static function orderCancelled()
    {
        return Order::where('status', 'cancelled')->count();
    }

    // doanh thu cho duyert
    public static function orderPending()
    {
        return Order::where('status', 'pending')->count();
    }

    // doanh thu da uy
    public static function totalRevenueCancelled()
    {
        return Order::where('status', 'cancelled')->sum('total');
    }
    public static function totalRevenuePending()
    {
        return Order::where('status', 'pending')->sum('total');
    }

    // don hang gan day
    public static function currentOrder()
    {
        return Order::orderBy('created_at', 'desc')->take(5)->get();
    }
    public static function totalRevenueApproved()
    {
        return Order::where('status', 'approved')->sum('total');
    }

    public static function totalRevenueCompleted()
    {
        return Order::where('status', 'completed')->sum('total');
    }

    // Lấy dữ liệu biểu đồ theo tháng
    public static function getMonthlyChartData()
    {
        $monthlyTotalRevenue = [];
        $monthlyPendingRevenue = [];
        $monthlyApprovedRevenue = [];

        // Lấy dữ liệu cho 12 tháng trong năm hiện tại
        for ($month = 1; $month <= 12; $month++) {
            // Tổng doanh thu theo tháng
            $totalRevenue = Order::whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->sum('total');
            $monthlyTotalRevenue[] = (float) $totalRevenue;

            // Doanh thu đơn hàng đang xử lý
            $pendingRevenue = Order::whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->where('status', 'pending')
                ->sum('total');
            $monthlyPendingRevenue[] = (float) $pendingRevenue;

            // Doanh thu đơn hàng đã duyệt
            $approvedRevenue = Order::whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->where('status', 'approved')
                ->sum('total');
            $monthlyApprovedRevenue[] = (float) $approvedRevenue;
        }

        return [
            'totalRevenue' => $monthlyTotalRevenue,
            'pendingRevenue' => $monthlyPendingRevenue,
            'approvedRevenue' => $monthlyApprovedRevenue
        ];
    }
}
