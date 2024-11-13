<?php

namespace App\Filament\User\Widgets;

use App\Models\GameInfo;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class TotalCoinsWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.total-coins-widget';

    public $coin;

    public function mount()
    {
        $this->coin = GameInfo::where('user_id', Auth::id())->value('coin') ?? 0;
    }
}
