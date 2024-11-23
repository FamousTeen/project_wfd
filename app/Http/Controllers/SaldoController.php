<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Account;
use Illuminate\Http\Request;
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
    // Validasi input
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0', // Pastikan jumlah saldo valid
    ]);

    // Mencari saldo yang terkait dengan account_id
    $saldo = Saldo::where('account_id', $accountId)->first();

    if (!$saldo) {
        return response()->json(['message' => 'Saldo tidak ditemukan'], 404);
    }

    // Update saldo
    $saldo->update([
        'amount' => $validated['amount'],
    ]);

    return response()->json($saldo, 200);
}


}
