<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteStatistic extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'total_users_registered',
        'daily_users_registered',
        'monthly_users_registered',
        'daily_active_users',
        'daily_active_guests',
        'monthly_active_users',
        'monthly_active_guests',
        'last_reset_at',
        'total_visits',
        'daily_visits',
        'monthly_visits',
    ];
    
     protected $attributes = [
        'total_users_registered' => 0,
        'daily_users_registered' => 0,
        'monthly_users_registered' => 0,
        'daily_active_users' => 0,
        'monthly_active_users' => 0,
        'daily_active_guests' => 0,
        'monthly_active_guests' => 0,
        'total_visits' => 0,
        'daily_visits' => 0,
        'monthly_visits' => 0,
    ];
    
}
