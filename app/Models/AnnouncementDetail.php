<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnouncementDetail extends Pivot
{
    use HasFactory;

    protected $table = 'announcement_details';

    public function announcement(): BelongsTo {
        return $this->belongsTo(Announcement::class);
    }
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
}
