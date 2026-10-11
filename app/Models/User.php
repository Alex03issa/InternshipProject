<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Observers\UserObserver;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name', 
        'email', 
        'password', 
        'user_type', 
        'profile_image', 
        'provider', 
        'google_id', 
        'apple_id', 
        'is_verified', 
        'verification_token',
        'timezone',
        'hashed_email',
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
        'password' => 'hashed',
    ];
    
    
    protected static function booted(): void
    {
        static::observe(UserObserver::class);
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * /admin is for admins only; /user (player panel) is for players.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->isAdmin(),
            'user' => !$this->isAdmin(),
            default => false,
        };
    }

    /**
     * Name shown in the Filament panels. Users who signed up with e-mail
     * only have a username, and Filament requires a non-null string.
     */
    public function getFilamentName(): string
    {
        return (string) ($this->name ?: $this->username ?: 'User');
    }

    public function getDisplayNameAttribute()
    {
        return $this->name ?? $this->username;  // Return name if set, otherwise username.
    }


    public function gameInfo()
    {
        return $this->hasOne(GameInfo::class, 'user_id','id');
    }

    public function siteStatistics()
    {
        return $this->hasMany(SiteStatistic::class, 'user_id');
    }

    public function gameStatistics()
    {
        return $this->hasOne(GameUserStatistic::class);
    }


    public function userStatistic()
    {
        return $this->hasOne(UserStatistic::class);
    }

}
