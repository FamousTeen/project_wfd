<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function listAll()
    {
        // Fetch all transactions with user details and paginate them
        $transactions = Transaction::with('account')->paginate(10);

        $user = Auth::guard('admin')->user();

        return view('admin.transaction_list', ['transactions' => $transactions, 'user'=> $user]);
    }

    
}