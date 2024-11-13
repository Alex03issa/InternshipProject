<?php

namespace App\Filament\User\Widgets;


use App\Models\GameInfo;
use Filament\Widgets\Widget;

class SelectedItemsWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.selected-items-widget';

    public ?string $selectedBackground = null;
    public ?string $selectedSkin = null;

    public function mount(): void
    {
        // Fetch the selected background and skin from the GameInfo table
        $gameInfo = GameInfo::first(); // Assuming there's only one row for simplicity

        // Use default values if not found
        $this->selectedBackground = $gameInfo->background_selected ?? 'default_background.png';
        $this->selectedSkin = $gameInfo->ball_skin_selected ?? 'default_ball_skin.png';
    }

    protected function getViewData(): array
    {
        return [
            'selectedBackground' => $this->selectedBackground,
            'selectedSkin' => $this->selectedSkin,
        ];
    }
}
