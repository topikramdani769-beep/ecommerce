{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="bg-white min-vh-100 py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="mb-5">
                    <h2 class="fw-bold text-dark">Lengkapi Pesanan</h2>
                    <p class="text-muted">Hanya satu langkah lagi sebelum pesanan Anda diproses.</p>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" id="form-checkout">
                    @csrf
                    
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="badge bg-muted rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">1</span>
                            <h5 class="mb-0 fw-bold text-uppercase tracking-wider">Tujuan Pengiriman</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none" id="name" value="{{ auth()->user()->name }}" placeholder="Nama Lengkap" required>
                                    <label for="name" class="px-0 text-muted">Nama Penerima</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" name="phone" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none" id="phone" placeholder="08xxx" required>
                                    <label for="phone" class="px-0 text-muted">Nomor Telepon</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea name="address" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none" id="address" style="height: 100px" placeholder="Alamat" required></textarea>
                                    <label for="address" class="px-0 text-muted">Alamat Lengkap (Jalan, No. Rumah, Kota)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex align-items-center mb-4">
                            <span class="badge bg-muted rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">2</span>
                            <h5 class="mb-0 fw-bold text-uppercase tracking-wider">Metode Pembayaran</h5>
                        </div>
                        
                        <div class="p-4 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="payment" id="transfer" checked>
                                <label class="form-check-label fw-bold ms-2" for="transfer">
                                    Transfer Bank Manual
                                </label>
                            </div>
                            <i class="bi bi-wallet2 fs-4 text-muted"></i>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 bg-light p-4 p-md-5 rounded-4 position-sticky" style="top: 2rem;">
                    <h5 class="fw-bold mb-4">Pesanan Anda</h5>
                    
                    <div class="pe-2" style="max-height: 280px; overflow-y: auto;">
                        @foreach($cart->items as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                <p class="mb-0 small text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                            </div>
                            <span class="fw-bold small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-top border-2 mt-4 pt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span class="text-success fw-bold">Gratis</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-end mb-5">
                            <h4 class="mb-0 fw-bold">Total</h4>
                            <h3 class="mb-0 fw-bolder text-dark">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</h3>
                        </div>

                        <button type="submit" form="form-checkout" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow-sm hover-up">
                            Bayar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        
                        <div class="mt-4 text-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" height="20" class="mx-2 grayscale opacity-50">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/2560px-Bank_Mandiri_logo_2016.svg.png" height="15" class="mx-2 grayscale opacity-50">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Desain Minimalis Modern */
    .form-control {
        background-color: transparent !important;
        border-color: #dee2e6 !important;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #000 !important;
    }
    .tracking-wider { letter-spacing: 0.05em; }
    .grayscale { filter: grayscale(100%); transition: 0.3s; }
    .grayscale:hover { filter: grayscale(0%); opacity: 1 !important; }
    .hover-up { transition: all 0.3s ease; }
    .hover-up:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    
    /* Scrollbar minimalis */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
</style>
@endsection