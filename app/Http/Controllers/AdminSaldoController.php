<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;

class AdminSaldoController extends Controller
{
    public function index()
    {
        $saldos = Saldo::with('account')->get(); // Fetch all saldo records
        return view('admin.admin_saldo', compact('saldos'));
    }

    public function updateSaldo(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
    
        $saldo = Saldo::findOrFail($id);
        $saldo->amount = $validated['amount'];
        $saldo->save();
    
        return redirect()->back()->with('success', 'Saldo updated successfully.');
    }
    



}