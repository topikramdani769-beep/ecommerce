@extends('layouts.app')

@section('content')
<style>
    /* Global Minimalist Style */
    body { background-color: #ffffff; color: #000; font-family: 'Inter', sans-serif; }
    
    .page-title { 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -1.5px; 
        font-size: 2rem;
        margin-bottom: 30px;
    }

    /* Luxury Table Styling */
    .table-container {
        border: 2px solid #000;
        border-radius: 0px;
        overflow: hidden;
    }

    .table thead {
        background-color: #000;
        color: #fff;
    }

    .table thead th {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px 20px;
        border: none;
    }

    .table tbody td {
        padding: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        border-bottom: 1px solid #eee;
        color: #000;
    }

    /* Custom Status Badge (Monochrome) */
    .status-badge {
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        padding: 5px 12px;
        border: 1px solid #000;
        display: inline-block;
        letter-spacing: 1px;
    }

    .status-pending { background: #fff; color: #000; border-style: dashed; }
    .status-process { background: #f8f8f8; color: #000; }
    .status-shipped { background: #000; color: #fff; }
    .status-done { background: #000; color: #fff; }
    .status-cancel { border-color: #d9534f; color: #d9534f; }

    /* Button Action */
    .btn-detail {
        background: transparent;
        color: #000;
        border: 1px solid #000;
        border-radius: 0px;
        font-weight: 900;
        font-size: 0.65rem;
        text-transform: uppercase;
        padding: 8px 15px;
        transition: 0.3s;
    }

    .btn-detail:hover {
        background: #000;
        color: #fff;
    }

    /* Order Number Link */
    .order-link {
        color: #000;
        text-decoration: underline;
        font-family: 'Courier New', Courier, monospace;
    }

    /* Pagination Styling */
    .pagination .page-link {
        color: #000;
        border: 1px solid #000;
        border-radius: 0px !important;
        margin: 0 2px;
        font-weight: 900;
    }
    .pagination .page-item.active .page-link {
        background-color: #000;
        border-color: #000;
    }
</style>

<div class="container py-5">
    <h1 class="page-title">PESANAN <span class="text-muted">SAYA</span></h1>
    
    <div class="table-container shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>NO. ORDER</th>
                        <th>TANGGAL</th>
                        <th>STATUS</th>
                        <th>TOTAL</th>
                        <th class="text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="order-link fw-bold">
                                #{{ $order->order_number }}
                            </a>
                        </td>
                        <td class="text-muted">
                            {{ $order->created_at->format('d / m / Y') }}
                        </td>
                        <td>
                            @php
                                $statusClass = '';
                                if($order->status == 'pending') $statusClass = 'status-pending';
                                elseif($order->status == 'processing') $statusClass = 'status-process';
                                elseif(in_array($order->status, ['shipped', 'delivered'])) $statusClass = 'status-done';
                                elseif($order->status == 'cancelled') $statusClass = 'status-cancel';
                            @endphp
                            <div class="status-badge {{ $statusClass }}">
                                @if($order->status == 'pending') Menunggu
                                @elseif($order->status == 'processing') Diproses
                                @elseif($order->status == 'shipped') Dikirim
                                @elseif($order->status == 'delivered') Sampai
                                @elseif($order->status == 'cancelled') Batal
                                @else {{ $order->status }}
                                @endif
                            </div>
                        </td>
                        <td class="fw-900">
                            IDR {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-detail">
                                DETAIL
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="ti ti-package-off fs-1 d-block mb-3 text-muted"></i>
                            <span class="fw-900 text-muted small uppercase">Belum ada riwayat pesanan</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection