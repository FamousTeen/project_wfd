<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MisaPermission extends Pivot
{
    use HasFactory;

    protected $table = 'misa_permissions';

    public function misaDetail(): BelongsTo {
        return $this->belongsTo(Misa_Detail::class);
    }
    public function admin(): BelongsTo {
        return $this->belongsTo(Admin::class);
    }
}
