<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'photo', 'status', 'address', 'birth_place_date', 'region', 'roles'];

    public function groupDetails(): HasMany
    {
        return $this->hasMany(GroupDetail::class);
    }

    public function trainingDetails(): HasMany
    {
        return $this->hasMany(TrainingDetail::class);
    }

    public function eventDetails(): HasMany
    {
        return $this->hasMany(EventDetail::class);
    }

    public function templatePermissions(): HasMany
    {
        return $this->hasMany(TemplatePermission::class);
    }

    public function announcementDetails(): HasMany
    {
        return $this->hasMany(AnnouncementDetail::class);
    }

    public function misaDetails(): HasMany
    {
        return $this->hasMany(Misa_Detail::class);
    }
}
