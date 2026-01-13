@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    <style>
        /* 1. Minimalist Base */
        body { 
            background-color: #f8f9fa; 
            font-family: 'Inter', -apple-system, sans-serif;
            color: #1a1a1a;
        }

        /* 2. Soft Card Design */
        .card { 
            border: 1px solid #e5e7eb !important; 
            border-radius: 12px !important; 
            background: #fff !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
            margin-bottom: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
        }

        /* Card Header Minimalist */
        .card-header { 
            border-bottom: 1px solid #f3f4f6 !important; 
            background: transparent !important;
            color: #111827 !important;
            padding: 16px 20px !important;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 3. Stat Cards */
        .card-link { text-decoration: none !important; color: inherit; }

        .icon-box {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            background: #f9fafb;
            color: #374151;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 1.1rem;
            border: 1px solid #f3f4f6;
        }

        /* 4. Badges & Typography */
        .live-status {
            background: #ecfdf5; color: #059669;
            padding: 4px 12px; font-size: 0.75rem;
            border-radius: 50px; font-weight: 600;
            border: 1px solid #d1fae5;
        }

        .fw-bold-700 { font-weight: 700 !important; }

        /* 5. Order Table Style */
        .order-row {
            border-bottom: 1px solid #f3f4f6;
            padding: 14px 0;
            transition: background 0.2s;
        }
        .order-row:last-child { border-bottom: none; }
        .order-row:hover { background: #f9fafb; }

        /* 6. Product Grid */
        .img-wrapper { 
            border-radius: 8px 8px 0 0;
            overflow: hidden; 
            background: #f3f4f6;
        }
        .img-product {
            height: 180px; object-fit: cover; width: 100%;
            transition: opacity 0.3s ease;
        }
        .card:hover .img-product { opacity: 0.85; }

        .sold-label {
            position: absolute; top: 12px; right: 12px;
            background: rgba(255,255,255,0.9); color: #111;
            padding: 2px 8px; font-size: 0.7rem; font-weight: 700;
            border-radius: 4px; border: 1px solid #e5e7eb;
        }

        .btn-modern {
            background: #111827; color: #fff;
            border: none; padding: 10px 16px;
            font-weight: 600; text-align: center; display: block;
            text-decoration: none; transition: 0.2s;
            border-radius: 8px;
            font-size: 0.85rem;
        }
        .btn-modern:hover {
            background: #374151; color: #fff;
        }
    </style>

    {{-- Dashboard Top Bar --}}
    <div class="d-flex justify-content-between align-items-end mb-4 px-2">
        <div>
            <h2 class="fw-bold-700 m-0" style="font-size: 1.75rem; letter-spacing: -0.5px;">Ringkasan Toko</h2>
            <p class="text-muted small mt-1">Selamat datang kembali, Admin. Berikut adalah performa toko hari ini.</p>
        </div>
        <div class="live-status">
            <span class="me-1">●</span> Sistem Aktif
        </div>
    </div>

    {{-- 1. Stats Grid --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.reports.sales') }}" class="card-link">
                <div class="card p-4">
                    <div class="icon-box"><i class="bi bi-wallet2"></i></div>
                    <span class="small fw-semibold text-muted">Total Pendapatan</span>
                    <h4 class="mb-0 fw-bold-700 mt-1">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.orders.index') }}" class="card-link">
                <div class="card p-4">
                    <div class="icon-box"><i class="bi bi-bag"></i></div>
                    <span class="small fw-semibold text-muted">Pesanan Baru</span>
                    <h4 class="mb-0 fw-bold-700 mt-1">{{ $stats['pending_orders'] ?? 0 }} Produk</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.products.index') }}" class="card-link">
                <div class="card p-4">
                    <div class="icon-box"><i class="bi bi-exclamation-circle"></i></div>
                    <span class="small fw-semibold text-muted">Stok Menipis</span>
                    <h4 class="mb-0 fw-bold-700 mt-1 text-danger">{{ $stats['low_stock'] ?? 0 }} Item</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.products.index') }}" class="card-link">
                <div class="card p-4">
                    <div class="icon-box"><i class="bi bi-box-seam"></i></div>
                    <span class="small fw-semibold text-muted">Total Produk</span>
                    <h4 class="mb-0 fw-bold-700 mt-1">{{ $stats['total_products'] ?? 0 }}</h4>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- 2. Chart Section --}}
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    Grafik Penjualan
                    <span class="text-muted fw-normal" style="font-size: 0.75rem;">7 Hari Terakhir</span>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        {{-- 3. Recent Orders --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    Pesanan Terbaru
                </div>
                <div class="card-body p-4">
                    @forelse($recentOrders as $order)
                        <div class="order-row d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold small">#{{ $order->order_number }}</div>
                                <div class="text-muted small">{{ $order->user->name ?? 'Pembeli Umum' }}</div>
                            </div>
                            <div class="text-end fw-bold small">
                                Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">Tidak ada pesanan masuk.</div>
                    @endforelse
                    <div class="mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="btn-modern w-100">Lihat Semua Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Top Products Grid --}}
    <div class="mt-5 mb-5">
        <h5 class="fw-bold-700 mb-4 px-2">Produk Terlaris</h5>
        <div class="row g-3">
            @foreach($topProducts as $product)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card p-0 border-0 shadow-none">
                        <div class="img-wrapper">
                            <div class="sold-label">{{ $product->sold }} Terjual</div>
                            <img src="{{ $product->image_url }}" onerror="this.src='https://placehold.co/400x500/eeeeee/999999?text=Denim'" class="img-product">
                        </div>
                        <div class="pt-3 pb-2">
                            <h6 class="text-truncate fw-bold mb-1" style="font-size: 0.8rem; color: #374151;">{{ $product->name }}</h6>
                            <p class="text-muted small mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($revenueChart->pluck('date')) !!},
                        datasets: [{
                            data: {!! json_encode($revenueChart->pluck('total')) !!},
                            borderColor: '#111827',
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 5,
                            fill: true,
                            backgroundColor: 'rgba(17, 24, 39, 0.02)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { 
                                grid: { borderDash: [5, 5], color: '#f3f4f6' },
                                ticks: { font: { size: 11 } }
                            },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
@endsection