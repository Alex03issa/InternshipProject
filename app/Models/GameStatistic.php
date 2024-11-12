<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_users_registered', 'daily_users_registered', 'monthly_users_registered', 'daily_active_users', 'monthly_active_users', 'daily_active_guests',
        'monthly_active_guests'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
