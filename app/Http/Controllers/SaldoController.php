<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

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
        // Validasi input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::guard('account')->user();

        // Mencari saldo yang terkait dengan account_id
        // Retrieve saldo for the current user
        $saldo = Saldo::where('account_id', $user->id)->first();

        if ($saldo) {
            // Update saldo by adding the top-up amount
            $saldo->update([
                'amount' => $saldo->amount + $validated['amount'],
            ]);
        } else {
            // Create new saldo if none exists
            $saldo = Saldo::create([
                'account_id' => $user->id,
                'amount' => $validated['amount'],
            ]);
        }

        // Record the transaction
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