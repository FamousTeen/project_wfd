<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSaldoController extends Controller
{
    public function index()
    {
        $saldos = Saldo::with('account')->get(); // Fetch all saldo records
        $user = Auth::guard('admin')->user();
        return view('admin.admin_saldo', compact('saldos', 'user'));
    }

    public function updateSaldo(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
    
        $saldo = Saldo::findOrFail($id);
    
        // Calculate the difference between the old and new amount
        $difference = $validated['amount'] - $saldo->amount;
    
        if ($difference != 0) { // Proceed only if there's a change
            // Log the transaction for this account
            $transaction = new Transaction();
            $transaction->account_id = $saldo->account_id; // Assumes Saldo is linked to a user/account
            $transaction->amount = abs($difference);
            $transaction->type = $difference > 0 ? 'credit' : 'debit';
            $transaction->save();
    
            // Update the saldo amount
            $saldo->amount = $validated['amount'];
            $saldo->save();
        }
    
        return redirect()->back()->with('success', 'Saldo updated successfully and transaction history recorded.');
    }
    
    



}