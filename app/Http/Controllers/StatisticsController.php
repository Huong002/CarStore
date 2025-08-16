<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    // Main statistics page with date filtering
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'month');
        $date = $request->get('date', now()->format('Y-m-d'));

        // Get statistics based on filter
        if ($filter === 'day') {
            $orderTotal = Order::whereDate('created_at', $date)->count();
            $orderPending = Order::whereDate('created_at', $date)->where('status', 'pending')->count();
            $orderCancelled = Order::whereDate('created_at', $date)->where('status', 'cancelled')->count();
            $orderComplated = Order::whereDate('created_at', $date)->where('status', 'completed')->count();
            $orderApprored = Order::whereDate('created_at', $date)->where('status', 'approved')->count();

            $totalStatis = Order::whereDate('created_at', $date)->sum('total');
            $totalStatisApproved = Order::whereDate('created_at', $date)->where('status', 'approved')->sum('total');
            $totalStatisComplated = Order::whereDate('created_at', $date)->where('status', 'completed')->sum('total');
            $totalStatisCancelled = Order::whereDate('created_at', $date)->where('status', 'cancelled')->sum('total');
            $totalStatisPending = Order::whereDate('created_at', $date)->where('status', 'pending')->sum('total');

            $currentOrders = Order::whereDate('created_at', $date)->orderBy('created_at', 'desc')->take(5)->get();
        } else {
            // Monthly statistics (default)
            $orderTotal = $this->totalOrder();
            $orderPending = $this->orderPending();
            $orderCancelled = $this->orderCancelled();
            $orderComplated = $this->orderCompleted();
            $orderApprored = $this->orderApproed();

            $totalStatis = $this->totalRevenue();
            $totalStatisApproved = $this->totalRevenueApproved();
            $totalStatisComplated = $this->totalRevenueCompleted();
            $totalStatisCancelled = $this->totalRevenueCancelled();
            $totalStatisPending = $this->totalRevenuePending();

            $currentOrders = $this->currentOrder();
        }

        // Get chart data
        $chartData = $this->getMonthlyChartData();

        return view('admin.index', compact(
            'orderTotal',
            'orderPending',
            'orderCancelled',
            'orderComplated',
            'currentOrders',
            'orderApprored',
            'totalStatis',
            'totalStatisCancelled',
            'totalStatisApproved',
            'totalStatisComplated',
            'totalStatisPending',
            'chartData',
            'filter',
            'date'
        ));
    }
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

    public function exportExcel(Request $request)
    {
        $filter = $request->get('filter', 'month');
        $date = $request->get('date', now()->format('Y-m-d'));

        if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            return back()->with('error', 'Chưa cài đặt thư viện PhpSpreadsheet!');
        }

        if ($filter === 'day') {
            $orders = Order::whereDate('created_at', $date)->get();
            $title = 'Danh_sach_don_hang_' . $date . '.xlsx';
        } else {
            $month = now()->format('Y-m');
            $orders = Order::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->get();
            $title = 'Danh_sach_don_hang_thang_' . $month . '.xlsx';
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'STT');
        $sheet->setCellValue('B1', 'Mã đơn hàng');
        $sheet->setCellValue('C1', 'Tên khách hàng');
        $sheet->setCellValue('D1', 'Số điện thoại');
        $sheet->setCellValue('E1', 'Tổng tiền');
        $sheet->setCellValue('F1', 'Trạng thái');
        $sheet->setCellValue('G1', 'Ngày tạo');

        $row = 2;
        foreach ($orders as $index => $order) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, 'DH' . str_pad($order->id, 6, '0', STR_PAD_LEFT));
            $sheet->setCellValue('C' . $row, $order->customer->customerName ?? '');
            $sheet->setCellValue('D' . $row, $order->customer->phone ?? '');
            $sheet->setCellValue('E' . $row, number_format($order->total, 0, ',', '.') . ' đ');
            $sheet->setCellValue('F' . $row, $order->status);
            $sheet->setCellValue('G' . $row, $order->created_at->format('d/m/Y H:i'));
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $title . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
