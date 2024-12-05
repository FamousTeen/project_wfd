<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SaldoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('account')->user();

        // Mengambil semua data saldo dari tabel saldos
        $saldo = Saldo::where('account_id', $user->id)->first();

        // Kirim data saldos ke view
        return view('anggota.saldo', ['saldo' => $saldo, 'user' => $user]);
    }


    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::guard('account')->user();

        // Create the saldo record
        Saldo::create([
            'account_id' => $user->id,
            'amount' => $validated['amount'],
        ]);

        return redirect()->route('saldo.index')->with('success', 'Saldo berhasil dibuat!');
    }

    public function getSaldo($accountId)
    {
        // Mengambil saldo berdasarkan account_id
        $saldo = Saldo::where('account_id', $accountId)->first();

        // Jika saldo tidak ditemukan
        if (!$saldo) {
            return response()->json(['message' => 'Saldo tidak ditemukan'], 404);
        }

        return response()->json($saldo, 200);
    }

    public function updateSaldo(Request $request, $accountId)
    {
        // Validate input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::guard('account')->user();

        // Retrieve saldo for the user, if exists
        $saldo = Saldo::where('account_id', $user->id)->first();

        if ($saldo) {
            // If saldo exists, update it
            $saldo->update([
                'amount' => $saldo->amount + $validated['amount'],
            ]);
        } else {
            // If saldo doesn't exist, create a new one
            $saldo = Saldo::create([
                'account_id' => $user->id,
                'amount' => $validated['amount'],
            ]);
        }

        // Record the transaction (log the top-up transaction)
        Transaction::create([
            'account_id' => $user->id,
            'type' => 'credit',
            'amount' => $validated['amount'],
        ]);

        return redirect()->route('saldo.index')->with('success', 'Saldo berhasil diperbarui!');
    }


    public function transactionHistory()
    {
        $user = Auth::guard('account')->user();
        $transactions = Transaction::where('account_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('anggota.transactions', compact('transactions'));
    }

}