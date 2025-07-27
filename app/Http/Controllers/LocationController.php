<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Hiển thị trang bản đồ vị trí.
     */
    public function index(Request $request)
    {
        // Tọa độ mặc định: Trường Đại học Đồng Tháp
        $lat = 10.4553;
        $lng = 105.6326;

        // Nếu có query lat/lng (ví dụ: /location?lat=10&lng=105) thì dùng giá trị đó
        if ($request->has(['lat', 'lng'])) {
            $lat = $request->query('lat');
            $lng = $request->query('lng');
        }

        // Trả dữ liệu ra view
        return view('location', compact('lat', 'lng'));
    }
}