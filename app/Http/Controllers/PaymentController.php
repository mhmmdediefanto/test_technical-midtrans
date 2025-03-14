<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function handleNotification(Request $request)
    {
        // Log::info('Webhook Request Data', ['payload' => $request->all()]);

        Log::info('Server Key Used:', ['key' => config('midtrans.server_key')]);


        $payload = $request->all();

        Log::info('midtrans notification', [
            'payload' => $payload
        ]);

        $orderId = $payload['order_id'] ?? null;

        Log::info('midtrans order id', [
            'order_id' => $orderId
        ]);
        $statusCode = $payload['status_code'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            Log::error('Missing required fields in webhook payload');
            return response()->json(['status' => 'failed', 'message' => 'Invalid payload'], 400);
        }
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));

        if (!hash_equals($expectedSignature, $signatureKey)) {
            Log::error('Invalid Signature', [
                'expected' => $expectedSignature,
                'received' => $signatureKey,
                'order_id' => $orderId,
                'status_code' => $statusCode,
                'gross_amount' => $grossAmount,
                'server_key' => config('midtrans.server_key'),
            ]);
            return response()->json(['status' => 'failed'], 401);
        }



        $transaction = Payment::where('transaction_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['status' => 'transaction Id not found'], 401);
        }

        if ($transactionStatus == 'settlement') {
            $transaction->status = 'success';
            $transaction->payment_method = $payload['payment_type'] ?? 'unknown';
            $transaction->payment_time = now();

            // Periksa apakah payment type adalah virtual account dan memiliki va_numbers
            if (isset($payload['va_numbers']) && !empty($payload['va_numbers'])) {
                $transaction->payment_method .= ' (' . $payload['va_numbers'][0]['bank'] . ')';
            }

            if ($transaction->boking) {
                $transaction->boking->status = 'paid'; // Misalnya status booking berubah jadi "paid"
                $transaction->boking->save();
            }
            $transaction->save();
        } else if ($transactionStatus == 'expire' || $transactionStatus == 'deny') {
            $transaction->status = 'failed';

            if ($transaction->boking) {
                $transaction->boking->status = 'canceled'; // Status booking jadi "canceled"
                $transaction->boking->save();
            }
            $transaction->save();
        }


        return response()->json(['status' => 'success']);
    }
}
