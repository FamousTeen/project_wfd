<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'amount'
    ];

    protected $table = 'saldos';

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    


}


