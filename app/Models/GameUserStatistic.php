<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class GameUserStatistic extends Model
{
    use HasFactory;

    protected $table = 'gameuserstatistics';

    protected $fillable = [
        'user_id',
        'last_seen_online',
        'game_current_visit',
        'average_session_duration',
        'platform',
    ];

    /**
     * Define a relationship to the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
