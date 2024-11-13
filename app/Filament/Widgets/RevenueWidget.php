<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Ad;

class RevenueWidget extends Widget
{
    public $totalRevenue;
    public $pendingBills;

    protected static string $view = 'filament.widgets.revenue-widget';

    public function mount()
    {
        $this->totalRevenue = Ad::where('paid_status', true)->sum('bill');
        $this->pendingBills = Ad::where('paid_status', false)->sum('bill');
    }
}
