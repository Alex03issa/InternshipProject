<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visits',
        'last_visit',
        'total_users_registered',
        'daily_users_registered',
        'monthly_users_registered',
        'daily_active_users',
        'monthly_active_users',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
