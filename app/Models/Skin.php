<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skin extends Model
{
    use HasFactory;

    protected $fillable = [
        'skin_name', 'skin_image', 'unlock_points'
    ];

    public function gameInfos()
    {
        return $this->belongsToMany(GameInfo::class, 'game_info_skins', 'skin_id', 'game_info_id');
    }
}
