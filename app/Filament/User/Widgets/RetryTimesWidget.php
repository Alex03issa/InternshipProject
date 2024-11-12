<?php

namespace App\Filament\User\Widgets;


use App\Models\GameInfo;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class RetryTimesWidget extends Widget
{
    protected static string $view = 'filament.user.widgets.retry-times-widget';

    public $retry_times;

    public function mount()
    {
        $this->retry_times = GameInfo::where('user_id', Auth::id())->value('retry_times') ?? 0;
    }
}
