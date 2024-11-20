<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'file',
        'status'
    ];

    public function admin(): BelongsTo {
        return $this->belongsTo(Admin::class);
    }

    public function templatePermissions(): HasMany {
        return $this->hasMany(TemplatePermission::class);
    }
}
