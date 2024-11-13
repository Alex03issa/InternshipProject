<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skin extends Model
{
    use HasFactory;

    protected $fillable = [
        'skin_name', 'skin_image', 'cost'
    ];

    public function addUnlockedSkin($skinId)
    {
        $unlockedSkins = $this->unlocked_skin ?? [];
        if (!in_array($skinId, $unlockedSkins)) {
            $unlockedSkins[] = $skinId;
            $this->unlocked_skin = $unlockedSkins;
            $this->save();
        }
    }

    public function gameInfos()
    {
        return $this->belongsToMany(GameInfo::class, 'game_info_skins', 'skin_id', 'game_info_id');
    }
}
