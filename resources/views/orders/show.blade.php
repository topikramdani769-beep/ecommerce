{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* Global Style - Tema Luxury De Larache */
    body { background-color: #ffffff; color: #000; font-family: 'Inter', sans-serif; }
    
    .detail-container { border: 2px solid #000; border-radius: 0px; background: #fff; }

    .page-title { 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -1px; 
        font-size: 1.5rem;
    }

    /* Status Badge Minimalis */
    .status-badge {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        padding: 8px 16px;
        border: 1px solid #000;
        letter-spacing: 1px;
        display: inline-block;
    }
    .status-pending { background: #fff; border-style: dashed; color: #000; }
    .status-paid { background: #000; color: #fff; border-style: solid; }

    /* Tabel Produk */
    .table thead th {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #000;
        padding: 15px;
        background: #f8f8f8;
    }

    .table tbody td {
        font-size: 0.8rem;
        font-weight: 700;
        padding: 15px;
    }

    /* Label Bagian */
    .section-label {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #000;
        margin-bottom: 15px;
        display: block;
        border-left: 3px solid #000;
        padding-left: 10px;
    }

    /* Tombol Bayar Luxury */
    .btn-pay-now {
        background: #000 !important;
        color: #fff !important;
        border-radius: 0px;
        text-transform: uppercase;
        font-weight: 900;
        font-size: 0.85rem;
        letter-spacing: 2px;
        padding: 15px 40px;
        border: 1px solid #000;
        transition: 0.3s;
        width: 100%;
    }

    .btn-pay-now:hover {
        background: #fff !important;
        color: #000 !important;
    }

    /* Breadcrumb Custom */
    .breadcrumb-item, .breadcrumb-item a {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #000;
        text-decoration: none;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Navigasi Halaman --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">BERANDA</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">PESANAN SAYA</a></li>
                    <li class="breadcrumb-item active">DETAIL #{{ $order->order_number }}</li>
                </ol>
            </nav>

            <div class="detail-container shadow-sm overflow-hidden">
                {{-- Header Info Pesanan --}}
                <div class="p-4 border-bottom bg-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap g-3">
                        <div>
                            <h4 class="page-title mb-1">PESANAN #{{ $order->order_number }}</h4>
                            <div class="fw-bold text-muted small" style="font-family: 'Courier New';">
                                TANGGAL: {{ $order->created_at->format('d.m.Y / H:i') }} WIB
                            </div>
                        </div>

                        {{-- Status Badge Logika --}}
                        <div class="status-badge {{ $order->status == 'pending' ? 'status-pending' : 'status-paid' }}">
                            @if($order->status == 'pending') MENUNGGU PEMBAYARAN
                            @elseif($order->status == 'processing') SEDANG DIPROSES
                            @elseif($order->status == 'shipped') DALAM PENGIRIMAN
                            @elseif($order->status == 'delivered') PESANAN SELESAI
                            @elseif($order->status == 'cancelled') DIBATALKAN
                            @else {{ strtoupper($order->status) }} @endif
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <span class="section-label">Rincian Produk</span>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>NAMA PRODUK</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-end">HARGA SATUAN</th>
                                    <th class="text-end">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="fw-bold">{{ strtoupper($item->product_name) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="border-top: 2px solid #000;">
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td colspan="3" class="text-end py-2 fw-bold small">ONGKOS KIRIM</td>
                                    <td class="text-end py-2 fw-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end py-3 fw-900">TOTAL PEMBAYARAN</td>
                                    <td class="text-end py-3 fw-900 fs-5">
                                        IDR {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row g-0 border-top">
                    {{-- Detail Alamat --}}
                    <div class="col-md-6 p-4 border-end">
                        <span class="section-label">Alamat Pengiriman</span>
                        <div class="small fw-bold">
                            <p class="mb-1 text-uppercase">{{ $order->shipping_name }}</p>
                            <p class="mb-1 text-muted">{{ $order->shipping_phone }}</p>
                            <p class="mb-0 text-muted" style="line-height: 1.6; text-transform: uppercase;">{{ $order->shipping_address }}</p>
                        </div>
                    </div>

                    {{-- Bagian Pembayaran / Midtrans --}}
                    <div class="col-md-6 p-4 d-flex align-items-center justify-content-center bg-light">
                        @if($order->status === 'pending' && isset($snapToken))
                            <div class="text-center w-100 px-lg-4">
                                <p class="section-label text-center mb-3">Selesaikan Pembayaran</p>
                                <button id="pay-button" class="btn btn-pay-now shadow-none">
                                    BAYAR SEKARANG
                                </button>
                                <p class="small text-muted mt-3" style="font-size: 0.65rem;">Klik tombol di atas untuk memilih metode pembayaran aman.</p>
                            </div>
                        @else
                            <div class="text-center">
                                <i class="ti ti-discount-check fs-1 text-dark d-block mb-2"></i>
                                <p class="section-label mb-0 text-center">Transaksi Selesai</p>
                                <p class="small text-muted mb-0">Terima kasih telah berbelanja.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="fw-900 text-muted small" style="letter-spacing: 2px;">*** DE LARACHE - AUTHENTIC PERFUMERY ***</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(isset($snapToken))
        {{-- Load Midtrans Snap JS --}}
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');

                if (payButton) {
                    payButton.addEventListener('click', function() {
                        payButton.disabled = true;
                        payButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> MEMPROSES...';

                        window.snap.pay('{{ $snapToken }}', {
                            onSuccess: function(result) {
                                window.location.href = '{{ route("orders.success", $order) }}';
                            },
                            onPending: function(result) {
                                window.location.href = '{{ route("orders.index") }}';
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal, silakan coba lagi.');
                                payButton.disabled = false;
                                payButton.innerHTML = 'BAYAR SEKARANG';
                            },
                            onClose: function() {
                                payButton.disabled = false;
                                payButton.innerHTML = 'BAYAR SEKARANG';
                            }
                        });
                    });
                }
            });
        </script>
    @endif
@endpush