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
    // thong ke tong doanh thua
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
    public static function orderPenfing()
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
}
