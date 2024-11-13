<?php

namespace App\Filament\User\Widgets;

use App\Models\GameInfo;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class TotalScoreWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.total-score-widget';

    public $score;

    public function mount()
    {
        $this->score = GameInfo::where('user_id', Auth::id())->value('score') ?? 0;
    }
}
