<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::guard('account')->user();
        $uniqueOrderId = 'TOPUP-' . $user->id . '-' . time();

        // Create a pending transaction
        $transaction = Transaction::create([
            'account_id' => $user->id,
            'type' => 'credit',
            'amount' => $validated['amount'],
            'status' => 'pending',
            'order_id' => $uniqueOrderId,
        ]);

        // Midtrans configuration
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $uniqueOrderId,
                'gross_amount' => $validated['amount'],
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaction->update(['snap_token' => $snapToken]);

            return response()->json([
                'snapToken' => $snapToken,
                'order_id' => $uniqueOrderId,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to create Snap token: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error creating payment.']);
        }
    }

    public function updateTransactionAndSaldo(Request $request)
    {
        // Make sure the order ID exists and is pending
        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if ($transaction && $transaction->status == 'pending') {
            // Update transaction status to 'success'
            $transaction->status = 'success';
            $transaction->save();

            // Update or create saldo
            $saldo = Saldo::where('account_id', $transaction->account_id)->first();

            if ($saldo) {
                $saldo->amount += $transaction->amount;
                $saldo->save();
            } else {
                Saldo::create([
                    'account_id' => $transaction->account_id,
                    'amount' => $transaction->amount,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Transaction and saldo updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Transaction not found or already processed.']);
    }
}
