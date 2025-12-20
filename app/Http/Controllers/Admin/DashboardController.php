<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Statistik dashboard
        $stats = [
            'total_revenue'  => Order::sum('total_amount'),
            'total_orders'   => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock'      => Product::where('stock', '<=', 5)->count(),
        ];

        // Pesanan terbaru (INI YANG TADI HILANG)
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // KIRIM KEDUANYA KE VIEW
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
