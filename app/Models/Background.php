<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_name', 'background_image', 'unlock_points'
    ];


    public function gameInfos()
    {
        return $this->belongsToMany(GameInfo::class, 'game_info_backgrounds', 'background_id', 'game_info_id');
    }
}
