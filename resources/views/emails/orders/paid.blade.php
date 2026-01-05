{{-- resources/views/emails/orders/paid.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Mengimitasi Bootstrap 5 */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #212529; line-height: 1.5; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 20px; background-color: #fff; }
        .h1 { font-size: 1.5rem; font-weight: 500; margin-bottom: 1rem; color: #0d6efd; }
        .table { width: 100%; margin-bottom: 1rem; vertical-align: top; border-color: #dee2e6; border-collapse: collapse; }
        .table th { border-bottom: 2px solid #dee2e6; padding: 8px; text-align: left; }
        .table td { border-bottom: 1px solid #dee2e6; padding: 8px; }
        .btn { 
            display: inline-block; font-weight: 400; text-align: center; vertical-align: middle; 
            cursor: pointer; border: 1px solid transparent; padding: 0.375rem 0.75rem; 
            font-size: 1rem; border-radius: 0.25rem; text-decoration: none;
            color: #fff; background-color: #0d6efd; border-color: #0d6efd;
        }
        .text-muted { color: #6c757d; font-size: 0.875rem; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="h1">Halo, {{ $order->user->name }}</h1>
            <p>Terima kasih! Pembayaran untuk pesanan <strong>#{{ $order->order_number }}</strong> telah kami terima.</p>
            <p>Kami sedang memproses pesanan Anda.</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="fw-bold">Total</td>
                        <td style="text-align: right;" class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div style="margin: 30px 0; text-align: center;">
                <a href="{{ route('orders.show', $order) }}" class="btn">
                    Lihat Detail Pesanan
                </a>
            </div>

            <p class="text-muted">Jika ada pertanyaan, silakan balas email ini.</p>
            <p>Salam,<br><strong>{{ config('app.name') }}</strong></p>
        </div>
    </div>
</body>
</html>