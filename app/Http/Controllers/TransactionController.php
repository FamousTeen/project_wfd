<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function listAll()
    {
        // Fetch all transactions with user details and paginate them
        $transactions = Transaction::with('account')->paginate(10);

        return view('admin.transaction_list', ['transactions' => $transactions]);
    }

    
}