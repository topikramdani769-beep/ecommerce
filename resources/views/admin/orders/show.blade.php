@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<style>
    /* Global Style */
    body { background-color: #ffffff; color: #000; font-family: 'Inter', sans-serif; }
    
    .invoice-title { 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: -1.5px; 
        font-size: 2.2rem;
    }

    /* Section Headers */
    .section-label {
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.75rem;
        color: #000;
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
        margin-bottom: 25px;
        display: block;
    }

    .luxury-card {
        border-radius: 0px;
        border: 1px solid #f2f2f2;
        background: #fff;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        filter: grayscale(100%);
        border: 1px solid #f2f2f2;
    }
    .product-name {
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: -0.5px;
    }

    .form-select-luxury {
        border-radius: 0px;
        border: 1px solid #000;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 12px;
    }
    .btn-luxury-update {
        background: #000;
        color: #fff;
        border-radius: 0px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        padding: 15px;
        transition: 0.3s;
        border: none;
    }
    .btn-luxury-update:hover { background: #333; color: #fff; }

    .total-label { font-weight: 400; text-transform: uppercase; letter-spacing: 1px; }
    .total-amount { font-weight: 900; font-size: 1.5rem; letter-spacing: -1px; }

    .bi { font-family: bootstrap-icons !important; }
</style>

<div class="row justify-content-center mt-4 pb-5">
    <div class="col-lg-12">
        
        {{-- Pesan Feedback (PENTING AGAR TAHU JIKA UPDATE BERHASIL/GAGAL) --}}
        @if(session('success'))
            <div class="alert alert-dark rounded-0 border-0 mb-4 fw-bold text-uppercase small letter-spacing-1">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-0 border-0 mb-4 fw-bold text-uppercase small letter-spacing-1">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Top Navigation & Header --}}
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-dark small fw-900 text-uppercase letter-spacing-1 mb-2 d-block">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Manifest
                </a>
                <h2 class="invoice-title mb-0">Pesanan #{{ $order->order_number }}</h2>
                <p class="text-muted small mb-0 fw-bold mt-1 text-uppercase">Diterima: {{ $order->created_at->format('d F Y / H:i') }}</p>
            </div>
            <div class="text-end">
                <span class="badge rounded-0 bg-black text-uppercase px-3 py-2 fw-900" style="font-size: 0.65rem; letter-spacing: 1px;">
                    STATUS SAAT INI: {{ $order->status }}
                </span>
            </div>
        </div>

        <div class="row g-5">
            {{-- KIRI: LIST ITEM --}}
            <div class="col-lg-8">
                <span class="section-label">Rincian Barang</span>
                
                <div class="table-responsive">
                    <table class="table align-middle">
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-0" style="width: 100px;">
                                    <img src="{{ $item->product->image_url ?? asset('images/default-product.jpg') }}" class="product-img">
                                </td>
                                <td>
                                    <h6 class="product-name mb-1">{{ $item->product->name }}</h6>
                                    <div class="small text-muted fw-bold">HARGA SATUAN: IDR {{ number_format($item->price, 0, ',', '.') }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="small text-muted d-block fw-900 text-uppercase">Kuantitas</span>
                                    <span class="fw-bold">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-end pe-0">
                                    <span class="small text-muted d-block fw-900 text-uppercase">Subtotal</span>
                                    <span class="fw-900">IDR {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                    <span class="total-label">Total Kewajiban Pembayaran</span>
                    <span class="total-amount">IDR {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- KANAN: CUSTOMER & ACTION --}}
            <div class="col-lg-4">
                
                {{-- Info Customer --}}
                <div class="mb-5">
                    <span class="section-label">Informasi Pemesan</span>
                    <div class="p-4 luxury-card">
                        <h6 class="fw-900 text-uppercase mb-1" style="letter-spacing: -0.5px;">{{ $order->user->name }}</h6>
                        <p class="text-muted mb-0 small fw-bold">{{ $order->user->email }}</p>
                        <hr class="my-3 opacity-10">
                        <div class="small">
                            <span class="d-block text-muted text-uppercase fw-900 mb-1" style="font-size: 0.6rem; letter-spacing: 1px;">Alamat Pengiriman</span>
                            <span class="fw-bold text-uppercase" style="font-size: 0.75rem;">
                                {{ $order->shipping_address ?? 'Alamat tidak diisi' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Update Status --}}
                <div>
                    <span class="section-label">Manajemen Status</span>
                    <div class="p-4 luxury-card bg-light border-0">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label class="small text-uppercase fw-900 letter-spacing-1 d-block mb-3">Pilih Status Baru</label>
                                <select name="status" class="form-select form-select-luxury">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>PENDING (MENUNGGU)</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>PROCESSING (PENGEMASAN)</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>DELIVERED (SELESAI/TERKIRIM)</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>CANCELLED (BATAL)</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-luxury-update w-100">
                                Konfirmasi Perubahan
                            </button>
                        </form>

                        @if($order->status == 'cancelled')
                        <div class="mt-4 p-3 bg-white border border-danger text-danger small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                            <i class="bi bi-info-circle-fill me-2"></i> Pesanan Dibatalkan. Stok telah dikembalikan otomatis.
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection