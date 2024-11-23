<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Saldo;

class SaldoSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua akun dari tabel accounts
        $accounts = Account::all();

        // Iterasi setiap akun dan tambahkan data saldo
        // foreach ($accounts as $account) {
        //     Saldo::create([
        //         'account_id' => $account->id, // Mengambil ID dari tabel accounts
        //         'amount' => 0, // Nilai saldo default
        //     ]);
        // }
    }
}


