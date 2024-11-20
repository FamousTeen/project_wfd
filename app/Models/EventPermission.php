<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\EventDetail;

class EventPermission extends Pivot
{
    use HasFactory;

    protected $table = 'event_permissions';

    protected $fillable = [
        'event_detail_id',
        'admin_id'
    ];

    public function eventDetail(): BelongsTo {
        return $this->belongsTo(EventDetail::class);
    }
    public function admin(): BelongsTo {
        return $this->belongsTo(Admin::class);
    }
}
