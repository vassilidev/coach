<?php

namespace App\Models;

use App\Traits\Relations\MorphMany\MorphManyEvents;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    protected $table = 'users';

    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRoles,
        SoftDeletes,
        MorphManyEvents;

    protected $with = [
        'teacherProfile'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'socialite_id',
        'login_provider',
        'socialite_token',
        'socialite_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'avatar',
    ];

    /**
     * @return HasOne<Teacher, User>
     */
    public function teacherProfile(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getAvatarAttribute(): string
    {
        return 'https://api.dicebear.com/7.x/adventurer/png?seed=' . urlencode($this->name);
    }

    public function checkouts(): HasMany
    {
        return $this->hasMany(Checkout::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
