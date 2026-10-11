<?php

namespace App\Filament\User\Widgets;


use App\Models\Background;
use App\Models\GameInfo;
use App\Models\Skin;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class SelectedItemsWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.selected-items-widget';

    public ?string $selectedBackground = null;
    public ?string $selectedSkin = null;

    public function mount(): void
    {
        // Fetch the logged-in player's selected background and skin
        $gameInfo = GameInfo::where('user_id', Auth::id())->first();

        // The game API stores item ids; older rows hold a default file name.
        $this->selectedBackground = $this->resolveImage(
            $gameInfo?->background_selected,
            fn ($id) => Background::find($id)?->background_image
        ) ?? 'default_background.png';

        $this->selectedSkin = $this->resolveImage(
            $gameInfo?->ball_skin_selected,
            fn ($id) => Skin::find($id)?->skin_image
        ) ?? 'default_ball_skin.png';
    }

    private function resolveImage($value, callable $findImage): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return is_numeric($value) ? $findImage((int) $value) : (string) $value;
    }

    protected function getViewData(): array
    {
        return [
            'selectedBackground' => $this->selectedBackground,
            'selectedSkin' => $this->selectedSkin,
        ];
    }
}
