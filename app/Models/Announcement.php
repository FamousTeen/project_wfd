<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'announcements';

    protected $fillable = [
        'admin_id',
        'datetime',
        'description',
        'upload_time',
        'type',
        'status'
    ];

    public function announcementDetails(): HasMany {
        return $this->hasMany(AnnouncementDetail::class);
    }

    public function admin(): BelongsTo {
        return $this->belongsTo(Admin::class);
    }
}
