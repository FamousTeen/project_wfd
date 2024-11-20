<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupDetail extends Pivot
{
    use HasFactory;

    public function group(): BelongsTo {
        return $this->belongsTo(Group::class);
    }
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
}
