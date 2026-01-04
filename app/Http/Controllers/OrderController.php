<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik user yang sedang login.
     */
    public function index()
    {
        // PENTING: Jangan gunakan Order::all() !
        // Kita hanya mengambil order milik user yg sedang login menggunakan relasi hasMany.
        // auth()->user()->orders() akan otomatis memfilter: WHERE user_id = current_user_id
        $orders = auth()->user()->orders()
            ->with(['items.product']) // Eager Load nested: Order -> OrderItems -> Product
            ->latest() // Urutkan dari pesanan terbaru
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
    // 1. Cek keamanan akses
    if ($order->user_id !== auth()->id()) {
        abort(403, 'Akses ditolak.');
    }

    // 2. Load detail produk
    $order->load(['items.product']);

    // 3. Inisialisasi token
    $snapToken = null;

    // 4. Minta token ke Midtrans jika status masih pending
    if ($order->status === 'pending') {
        // Set konfigurasi dari file config/midtrans.php
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            // Membuat Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            // Jika gagal (misal server key salah), biarkan snapToken null
            // Anda bisa log errornya: logger($e->getMessage());
        }
    }

    // 5. Kirim data ke view
    return view('orders.show', compact('order', 'snapToken'));
}

    /**
     * Menampilkan halaman status pembayaran sukses.
     */
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
        return view('orders.success', compact('order'));
    }

    /**
     * Menampilkan halaman status pembayaran pending.
     */
    public function pending(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
        return view('orders.pending', compact('order'));
    }
}