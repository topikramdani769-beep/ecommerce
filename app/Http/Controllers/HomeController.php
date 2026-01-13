<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     */
    public function index()
    {
        // ================================================
        // AMBIL DATA KATEGORI
        // Menampilkan kategori yang aktif tanpa mempedulikan jumlah produk
        // ================================================
        $categories = Category::query()
            ->active() // Mengambil yang is_active = true
            ->orderBy('name')
            ->take(6)
            ->get();

        // ================================================
        // PRODUK UNGGULAN (FEATURED)
        // ================================================
        $featuredProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        // ================================================
        // PRODUK TERBARU
        // ================================================
        $latestProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        // ================================================
        // KIRIM DATA KE VIEW
        // ================================================
        return view('home', compact(
            'categories',
            'featuredProducts',
            'latestProducts'
        ));
    }
}