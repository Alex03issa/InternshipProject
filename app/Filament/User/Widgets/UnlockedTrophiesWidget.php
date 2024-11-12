<?php

namespace App\Filament\User\Widgets;

use App\Models\GameInfo;
use App\Models\Trophy;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class UnlockedTrophiesWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.unlocked-trophies-widget';

    public $trophies = [];

    public function mount()
    {
        // Fetch the unlocked trophy IDs for the logged-in user from GameInfo
        $gameInfo = GameInfo::where('user_id', Auth::id())->first();

        if ($gameInfo && $gameInfo->unlocked_trophy) {
            // Decode JSON array of unlocked trophy IDs
            $unlockedTrophyIds = json_decode($gameInfo->unlocked_trophy, true);

            // Fetch trophy images where IDs match the unlocked trophy IDs
            $this->trophies = Trophy::whereIn('id', $unlockedTrophyIds)
                ->pluck('icon')
                ->toArray();
        }
    }

    protected function getViewData(): array
    {
        return [
            'trophies' => $this->trophies,
        ];
    }
}
