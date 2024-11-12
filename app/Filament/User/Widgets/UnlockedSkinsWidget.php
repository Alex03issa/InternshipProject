<?php

namespace App\Filament\User\Widgets;

use App\Models\GameInfo;
use App\Models\Skin;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class UnlockedSkinsWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.unlocked-skins-widget';

    public $skins = [];

    public function mount()
    {
        $gameInfo = GameInfo::where('user_id', Auth::id())->first();

        if ($gameInfo && $gameInfo->unlocked_skin) {
            // Fetch only the skins that match the unlocked IDs
            $this->skins = Skin::whereIn('id', $gameInfo->unlocked_skin)->get();
        }
    }

    protected function getViewData(): array
    {
        return [
            'skins' => $this->skins,
        ];
    }
}
