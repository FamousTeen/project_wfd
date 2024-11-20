<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingDetail extends Pivot
{
    protected $table = 'training_details';

    use HasFactory;

    public function training(): BelongsTo {
        return $this->belongsTo(Training::class);
    }
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
}
