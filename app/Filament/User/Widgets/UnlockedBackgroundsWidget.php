<?php

namespace App\Filament\User\Widgets;

use App\Models\GameInfo;
use App\Models\Background;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class UnlockedBackgroundsWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.unlocked-backgrounds-widget';

    public $backgrounds = [];

    public function mount()
    {
        // Fetch the unlocked background IDs for the logged-in user from GameInfo
        $gameInfo = GameInfo::where('user_id', Auth::id())->first();

        if ($gameInfo && $gameInfo->unlocked_background) {
            // Decode JSON array of unlocked background IDs
            $unlockedBackgroundIds = json_decode($gameInfo->unlocked_background, true);

            // Fetch background images where IDs match the unlocked background IDs
            $this->backgrounds = Background::whereIn('id', $unlockedBackgroundIds)
                ->pluck('background_image')
                ->toArray();
        }
    }

    protected function getViewData(): array
    {
        return [
            'backgrounds' => $this->backgrounds,
        ];
    }
}
