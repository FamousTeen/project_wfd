<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventDetail extends Pivot
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $table = 'event_details';

    protected $fillable = [
        'event_id',
        'account_id',
        'roles'
    ];

    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }

    public function eventPermissions(): HasMany {
        return $this->hasMany(EventPermission::class);
    }
}
