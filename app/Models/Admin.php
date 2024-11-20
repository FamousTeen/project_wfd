<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'birthdate',
        'region',
        'photo'
    ];

    public function misaPermissions(): HasMany {
        return $this->hasMany(MisaPermission::class);
    }

    public function eventPermissions(): HasMany {
        return $this->hasMany(EventPermission::class);
    }

    public function trainings(): HasMany {
        return $this->hasMany(Training::class);
    }

    public function templates(): HasMany {
        return $this->hasMany(Template::class);
    }

    public function announcements(): HasMany {
        return $this->hasMany(Announcement::class);
    }
}
