<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Misa_Detail extends Pivot
{
    use HasFactory;

    protected $table = 'misa_details';
    protected $fillable = ['misa_id', 'account_id', 'roles','participation','confirmation'];

    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
    public function misa(): BelongsTo {
        return $this->belongsTo(Misa::class);
    }

    public function misaPermissions(): HasMany {
        return $this->hasMany(MisaPermission::class);
    }
}