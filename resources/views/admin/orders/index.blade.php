@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<style>
    /* 1. Global Page Style */
    body { background-color: #ffffff; color: #000; font-family: 'Inter', sans-serif; }
    
    .page-title { 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -1.5px; 
        font-size: 2rem;
    }

    /* 2. Minimalist Status Filter */
    .filter-nav {
        display: flex;
        gap: 25px;
        border-bottom: 1px solid #f2f2f2;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }
    .filter-link {
        color: #999;
        text-decoration: none;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    .filter-link:hover, .filter-link.active {
        color: #000;
        border-bottom: 2px solid #000;
        padding-bottom: 13px;
    }

    /* 3. Luxury Table */
    .table thead th {
        background-color: #ffffff;
        border-bottom: 2px solid #000;
        color: #000;
        text-transform: uppercase;
        font-size: 0.65rem;
        font-weight: 900;
        letter-spacing: 1px;
        padding: 15px 10px;
    }
    .table tbody td {
        padding: 20px 10px;
        border-bottom: 1px solid #f2f2f2;
        vertical-align: middle;
    }

    /* 4. Order Specific Elements */
    .order-number {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 900;
        color: #000;
        font-size: 0.9rem;
    }
    .customer-name {
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.8rem;
        display: block;
        letter-spacing: -0.2px;
    }
    .timestamp {
        font-size: 0.7rem;
        color: #999;
        font-weight: 600;
    }

    /* 5. Minimal Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        font-size: 0.6rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 1px solid #000;
    }
    .status-pending { background: #fff; color: #000; border-color: #e0e0e0; color: #999; }
    .status-processing { background: #000; color: #fff; }
    .status-delivered { background: #fff; color: #000; border-width: 2px; } /* Untuk status Selesai */
    .status-cancelled { border-color: #ff0000; color: #ff0000; opacity: 0.5; }

    .btn-view-detail {
        color: #000;
        text-decoration: none;
        font-weight: 900;
        font-size: 0.65rem;
        text-transform: uppercase;
        border-bottom: 1px solid #000;
        transition: 0.2s;
    }
    .btn-view-detail:hover { opacity: 0.5; }
</style>

<div class="row justify-content-center mt-4 pb-5">
    <div class="col-lg-12">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="page-title mb-0">Manajemen Pesanan</h2>
                <p class="text-muted small mb-0 fw-bold mt-2 text-uppercase letter-spacing-1">Manifest Transaksi / Arus Keluar Barang</p>
            </div>
            <div class="text-end d-none d-md-block">
                <span class="text-muted small fw-900 text-uppercase letter-spacing-1 d-block">Periode</span>
                <span class="fw-bold">{{ date('F Y') }}</span>
            </div>
        </div>

        {{-- Filter Status Minimalist --}}
        <div class="filter-nav">
            <a class="filter-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">Semua Manifest</a>
            <a class="filter-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Tertunda</a>
            <a class="filter-link {{ request('status') == 'processing' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'processing']) }}">Proses</a>
            {{-- Menggunakan 'delivered' karena 'completed' tidak ada di database ENUM Anda --}}
            <a class="filter-link {{ request('status') == 'delivered' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'delivered']) }}">Selesai</a>
        </div>

        {{-- Table Content --}}
        <div class="card border-0 shadow-none">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="ps-0">No. Manifest</th>
                                <th>Identitas Pelanggan</th>
                                <th>Kronologi</th>
                                <th class="text-end">Total Nominal</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-0">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="ps-0">
                                    <span class="order-number">#{{ $order->order_number }}</span>
                                </td>
                                <td>
                                    <span class="customer-name">{{ $order->user->name }}</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $order->user->email }}</small>
                                </td>
                                <td>
                                    <span class="timestamp">{{ $order->created_at->format('d/m/Y') }}</span>
                                    <div class="fw-bold" style="font-size: 0.75rem;">{{ $order->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="text-end fw-900">
                                    IDR {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($order->status == 'pending')
                                        <span class="status-badge status-pending">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span class="status-badge status-processing">Diproses</span>
                                    @elseif($order->status == 'delivered' || $order->status == 'completed')
                                        <span class="status-badge status-delivered">Selesai</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="status-badge status-cancelled">Batal</span>
                                    @else
                                        <span class="status-badge">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-0">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn-view-detail">
                                        Rincian Pesanan
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <span class="text-muted text-uppercase fw-900 letter-spacing-2">Tidak Ada Data Transaksi</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-5 d-flex justify-content-start">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection