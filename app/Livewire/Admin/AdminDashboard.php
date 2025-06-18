<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $totalRevenue = 0;
    public $dailyRevenue = 0;
    public $monthlyRevenue = 0;
    public $dailySalesCount = 0;

    // Thống kê chi tiết số lượng bán theo sản phẩm hôm nay
    public $topSellingProducts = [];

    public function mount()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Tổng doanh thu đã thanh toán
        $this->totalRevenue = DB::table('orders')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Doanh thu hôm nay
        $this->dailyRevenue = DB::table('orders')
            ->where('payment_status', 'paid')
            ->whereDate('completed_at', $today)
            ->sum('total_amount');

        // Doanh thu tháng hiện tại
        $this->monthlyRevenue = DB::table('orders')
            ->where('payment_status', 'paid')
            ->whereBetween('completed_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');

        // Tổng số lượng món bán hôm nay
        $this->dailySalesCount = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->whereDate('orders.completed_at', $today)
            ->sum('order_items.quantity');

        // Thống kê món bán chạy hôm nay: tên món + tổng số lượng + tổng doanh thu từng món
        $this->topSellingProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_price) as total_revenue'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->whereDate('orders.completed_at', $today)
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                // Lấy tên sản phẩm từ bảng products
                $product = DB::table('products')->where('id', $item->product_id)->first();
                return [
                    'product_name' => $product ? $product->name : 'Sản phẩm không xác định',
                    'quantity' => $item->total_quantity,
                    'revenue' => $item->total_revenue,
                ];
            });
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
