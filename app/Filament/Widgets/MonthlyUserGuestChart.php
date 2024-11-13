<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\SiteStatistic;
use Carbon\Carbon;

class MonthlyUserGuestChart extends BarChartWidget
{
    protected static ?string $heading = 'Monthly Active Users vs Guests';

    protected function getData(): array
    {
        $monthlyStatistics = SiteStatistic::whereYear('created_at', Carbon::now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(monthly_active_users) as active_users, SUM(monthly_active_guests) as active_guests')
            ->groupBy('month')
            ->get();

        $months = collect(range(1, 12))->map(function ($month) use ($monthlyStatistics) {
            $stats = $monthlyStatistics->firstWhere('month', $month);
            return [
                'month' => Carbon::create()->month($month)->format('M'),
                'active_users' => $stats ? $stats->active_users : 0,
                'active_guests' => $stats ? $stats->active_guests : 0,
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Active Users',
                    'data' => $months->pluck('active_users')->toArray(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                ],
                [
                    'label' => 'Active Guests',
                    'data' => $months->pluck('active_guests')->toArray(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.6)',
                ]
            ],
            
            'labels' => $months->pluck('month')->toArray(),
        ];
    }
}
