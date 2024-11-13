<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PendingBillsWidget;
use App\Filament\Widgets\RevenueWidget;
use Filament\Pages\Page;
use App\Filament\Widgets\RevenueAndPendingBills;
use App\Filament\Widgets\MonthlyRegisteredUsers;
use App\Filament\Widgets\MonthlyRevenueChart;
use App\Filament\Widgets\MonthlyUserGuestChart;
use App\Filament\Widgets\DownloadStatisticsChartWidget;

class Dashboard extends Page
{
    protected static ?string $title = 'Dashboard';

    // Define the view explicitly
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function getWidgets(): array
    {
        return [
            // First row: Revenue and Pending Bills
            [
                RevenueWidget::class,
            ],
            // Second row: Monthly charts
            [
                MonthlyRegisteredUsers::class,
                MonthlyRevenueChart::class,
                MonthlyUserGuestChart::class,
            ],
            // Third row: Downloads in the bottom-right corner
            [
                DownloadStatisticsChartWidget::class,
            ],
        ];
    }
}
