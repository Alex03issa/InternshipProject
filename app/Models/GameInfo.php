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

    /**
     * Unlocked item ids as an int array, whatever form the column holds
     * (array cast, legacy double-encoded JSON string, or null).
     */
    public function unlockedIds(string $column): array
    {
        $value = $this->{$column};

        while (is_string($value)) {
            $decoded = json_decode($value, true);
            if ($decoded === null && $value !== 'null') {
                return [];
            }
            $value = $decoded;
        }

        return array_values(array_map('intval', is_array($value) ? $value : []));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
