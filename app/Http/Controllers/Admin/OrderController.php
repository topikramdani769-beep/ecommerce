<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user')
            ->when($request->status, function($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order untuk admin.
     */
    public function show(Order $order)
    {
        // Memuat item pesanan, produk di dalam item tersebut, dan user yang memesan
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan (Fungsi yang dicari oleh routes/web.php)
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1. Validasi Input status
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        // 2. Simpan status lama untuk pesan log (Opsional)
        $statusLama = strtoupper($order->status);
        $statusBaru = strtoupper($request->status);

        // 3. Update status di database
        $order->update([
            'status' => $request->status
        ]);

        // 4. Kembali ke halaman detail dengan pesan sukses gaya De Larache
        return redirect()->back()
            ->with('success', "STATUS UPDATED: PESANAN #{$order->order_number} BERUBAH DARI {$statusLama} MENJADI {$statusBaru}");
    }
}