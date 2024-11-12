<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\Ad;
use Carbon\Carbon;

class MonthlyRevenueChart extends BarChartWidget
{
    protected static ?string $heading = 'Revenue and Bills per Month';
    

    protected function getData(): array
    {
        // Fetch monthly revenue data from the `Ad` model where `paid_status` is true
        $monthlyRevenue = Ad::whereYear('created_at', Carbon::now()->year)
            ->where('paid_status', true)
            ->selectRaw('MONTH(created_at) as month, SUM(bill) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Fetch monthly pending bills data from the `Ad` model where `paid_status` is false
        $monthlyPendingBills = Ad::whereYear('created_at', Carbon::now()->year)
            ->where('paid_status', false)
            ->selectRaw('MONTH(created_at) as month, SUM(bill) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Generate an array for all 12 months with default values for revenue and pending bills
        $allMonths = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyRevenue, $monthlyPendingBills) {
            return [
                Carbon::create()->month($month)->format('F') => [
                    'revenue' => $monthlyRevenue->get($month, 0),
                    'pending' => -1 * $monthlyPendingBills->get($month, 0), // Make pending bills negative
                ],
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $allMonths->pluck('revenue')->toArray(),
                    'backgroundColor' => '#eb427e', // Orange for earnings
                ],
                [
                    'label' => 'Bills',
                    'data' => $allMonths->pluck('pending')->toArray(),
                    'backgroundColor' => '#594cda', // Red for expenses
                ]
            ],
            
            'labels' => $allMonths->keys()->toArray(),
        ];
    }
}
