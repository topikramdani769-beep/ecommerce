{{-- resources/views/admin/reports/sales.blade.php --}}

@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<style>
    body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
    
    .page-title { 
        font-weight: 800; 
        letter-spacing: -1px; 
        font-size: 1.75rem;
        color: #111827;
    }

    /* Soft Card Style */
    .card-luxury { 
        border: 1px solid #e5e7eb !important; 
        border-radius: 12px !important; 
        background: #fff !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
    }

    /* Filter Form Styling */
    .form-control-modern {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 10px 14px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .btn-dark-modern {
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: 0.2s;
    }
    .btn-dark-modern:hover { background: #374151; color: #fff; }

    .btn-outline-modern {
        background: #fff;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: 0.2s;
    }
    .btn-outline-modern:hover { background: #f9fafb; border-color: #d1d5db; }

    /* Summary Stats */
    .stat-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; }
    .stat-value { font-size: 1.5rem; font-weight: 800; color: #111827; margin-top: 4px; }

    /* Progress Bar */
    .progress-minimal { height: 6px; border-radius: 10px; background-color: #f3f4f6; }
    .progress-bar-dark { background-color: #111827; }

    /* Table Styling */
    .table thead th {
        background: transparent;
        border-bottom: 1px solid #f3f4f6;
        color: #6b7280;
        text-transform: uppercase;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 15px 12px;
    }
    .table tbody td { padding: 16px 12px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; font-size: 0.85rem; }
</style>

<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-end mb-4 px-2">
        <div>
            <h2 class="page-title m-0">Laporan Penjualan</h2>
            <p class="text-muted small mt-1">Analisis performa pendapatan dan tren kategori produk.</p>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card card-luxury mb-4">
        <div class="card-body p-4">
            <form method="GET" class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="stat-label mb-2 d-block">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control form-control-modern">
                </div>
                <div class="col-md-3">
                    <label class="stat-label mb-2 d-block">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control form-control-modern">
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-dark-modern">
                        <i class="bi bi-funnel me-1"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin.reports.export-sales', request()->all()) }}" class="btn btn-outline-modern text-success border-success">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Grid --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card card-luxury p-4 border-start border-dark border-4">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}</div>
                <div class="text-muted text-xs mt-1 fw-medium">Omset kotor periode terpilih</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-luxury p-4 border-start border-primary border-4">
                <div class="stat-label">Volume Transaksi</div>
                <div class="stat-value">{{ number_format($summary->total_orders ?? 0) }} Pesanan</div>
                <div class="text-muted text-xs mt-1 fw-medium">Hanya menghitung order yang dibayar</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Category Performance --}}
        <div class="col-lg-4">
            <div class="card card-luxury h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6 class="fw-bold m-0">Performa Kategori</h6>
                </div>
                <div class="card-body px-4">
                    @forelse($byCategory as $cat)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold text-dark small">{{ $cat->name }}</span>
                                <span class="fw-bold small">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="progress progress-minimal">
                                <div class="progress-bar progress-bar-dark" role="progressbar"
                                     style="width: {{ ($cat->total / ($summary->total_revenue ?: 1)) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">Data kategori kosong</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="col-lg-8">
            <div class="card card-luxury h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h6 class="fw-bold m-0">Rincian Transaksi Tertutup</h6>
                </div>
                <div class="table-responsive p-2">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Identitas Pelanggan</th>
                                <th class="text-end">Total Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-dark text-decoration-none">
                                            #{{ $order->order_number }}
                                        </a>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $order->user->name }}</div>
                                        <div class="text-muted text-xs">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="text-end fw-bold">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted small">
                                        Tidak ditemukan transaksi pada rentang tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 p-4">
                    {{ $orders->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection