<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplatePermission extends Pivot
{
    use HasFactory;

    public function template(): BelongsTo {
        return $this->belongsTo(Template::class);
    }
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
}
