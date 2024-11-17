<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Panel;

class User extends Authenticatable
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
