<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameInfo extends Model
{
    use HasFactory;

    protected $table = 'game_info'; 

    protected $fillable = [
        'user_id', 'score', 'retry_times', 'coin', 'unlocked_skins', 'unlocked_backgrounds', 'unlocked_trophies', 'background_selected', 'ball_skin_selected'
    ];

    protected $casts = [
        'unlocked_skins' => 'array', // Assuming skins are stored as JSON
        'unlocked_backgrounds' => 'array', // Assuming skins are stored as JSON
        'unlocked_trophies' => 'array', // Assuming trophies are stored as JSON
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function skins()
    {
        return $this->belongsToMany(Skin::class, 'game_info_skins', 'game_info_id', 'skin_id');
    }

    public function backgrounds()
    {
        return $this->belongsToMany(Background::class, 'game_info_backgrounds', 'game_info_id', 'background_id');
    }

    public function trophies()
    {
        return $this->belongsToMany(Trophy::class, 'game_info_trophies', 'game_info_id', 'trophy_id');
    }
}
