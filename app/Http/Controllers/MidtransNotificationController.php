<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    /**
     * Handle incoming webhook notification from Midtrans.
     * URL: POST /midtrans/notification
     */
    public function handle(Request $request)
    {
        // 1. Ambil data notifikasi mentah
        $payload = $request->all();

        // Log untuk debugging (Cek storage/logs/laravel.log jika ada masalah)
        Log::info('Midtrans Notification Received', $payload);

        // 2. Extract Data Penting
        $orderId           = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $paymentType       = $payload['payment_type'] ?? null;
        $transactionId     = $payload['transaction_id'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;

        // 3. Validasi Field Wajib
        if (!$orderId || !$transactionStatus || !$signatureKey) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // 4. VALIDASI SIGNATURE KEY (Gunakan gross_amount asli dari payload agar hash cocok)
        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $payload['gross_amount'] . $serverKey
        );

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans Notification: Invalid signature', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 5. Cari Order di Database (Pastikan kolom 'order_number' sesuai screenshot Anda)
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning("Midtrans Notification: Order not found", ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 6. Cek jika order sudah pernah diproses sebelumnya (Idempotency)
        if (in_array($order->status, ['processing', 'shipped', 'delivered', 'cancelled']) && $transactionStatus !== 'pending') {
            return response()->json(['message' => 'Order already processed'], 200);
        }

        // 7. Update Data Pembayaran (Jika ada relasi payment)
        if ($order->payment) {
            $order->payment->update([
                'midtrans_transaction_id' => $transactionId,
                'payment_type'            => $paymentType,
                'raw_response'            => json_encode($payload),
            ]);
        }

        // 8. MAPPING STATUS TRANSAKSI
        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus === 'challenge') {
                    $this->handlePending($order);
                } else {
                    $this->handleSuccess($order);
                }
                break;

            case 'settlement':
                $this->handleSuccess($order);
                break;

            case 'pending':
                $this->handlePending($order);
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $this->handleFailed($order);
                break;

            case 'refund':
            case 'partial_refund':
                $order->update(['payment_status' => 'refunded']);
                break;
        }

        return response()->json(['message' => 'Notification processed'], 200);
    }

    protected function handleSuccess($order)
    {
        Log::info("Payment SUCCESS for Order: {$order->order_number}");

        $order->update([
            'status' => 'processing', 
            'payment_status' => 'paid',
        ]);

        if ($order->payment) {
            $order->payment->update([
                'status'  => 'success',
                'paid_at' => now(),
            ]);
        }
    }

    protected function handlePending($order)
    {
        $order->update(['payment_status' => 'unpaid']);
        
        if ($order->payment) {
            $order->payment->update(['status' => 'pending']);
        }
    }

    protected function handleFailed($order)
    {
        $order->update(['status' => 'cancelled', 'payment_status' => 'failed']);

        if ($order->payment) {
            $order->payment->update(['status' => 'failed']);
        }

        // Kembalikan stok
        foreach ($order->items as $item) {
            $item->product?->increment('stock', $item->quantity);
        }
    }
}