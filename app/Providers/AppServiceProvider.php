<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category; // Tambahkan ini
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);

        // Bagikan data kategori ke SEMUA view (termasuk navbar di partials bawah)
        View::share('categories', Category::where('is_active', true)->orderBy('name')->get());
    }
}