<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trophy extends Model
{
    use HasFactory;

    protected $fillable = [
        'trophy_name', 'trophy_description', 'icon', 'unlock_points'
    ];

    public function gameInfos()
    {
        return $this->belongsToMany(GameInfo::class, 'game_info_trophies', 'trophy_id', 'game_info_id');
    }
}
