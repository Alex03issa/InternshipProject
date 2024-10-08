<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'score',
        'retry_times',
        'level',
        'speed',
        'reward_points',
        'unlocked_skins',
        'unlocked_backgrounds',
        'unlocked_trophies',
        'ball_skin',
        'background',
        'average_session_duration',
        'total_achievements',
        'last_active',
    ];

    protected $casts = [
        'unlocked_skins' => 'array', // Assuming skins are stored as JSON
        'unlocked_backgrounds' => 'array', // Assuming skins are stored as JSON
        'unlocked_trophies' => 'array', // Assuming trophies are stored as JSON
        'last_active' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
