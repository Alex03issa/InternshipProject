<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\User;
use Carbon\Carbon;

class MonthlyRegisteredUsers extends LineChartWidget
{
    protected static ?string $heading = 'Monthly Registered Users';
    

    public $selectedMonth;

    public function mount(): void
    {
        $this->selectedMonth = now()->format('Y-m'); // Default to current month
    }

    protected function getData(): array
    {
        $month = $this->selectedMonth ? Carbon::parse($this->selectedMonth) : now();
        $isCurrentMonth = $month->isSameMonth(now());

        // Fetch daily registrations for the selected month
        $dailyRegistrations = User::whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day');

        // Fill days up to the current day (if it's the current month) or the end of the selected month
        $daysInMonth = $isCurrentMonth ? now()->day : $month->daysInMonth;
        $data = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $data[] = $dailyRegistrations->get($i, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Registrations',
                    'data' => $data,
                ],
            ],
            
            'labels' => range(1, $daysInMonth), // Only show days up to the current day for the current month
        ];
    }

    private function getMonthOptions(): array
    {
        // Generate options for the last 12 months, including the current month
        $options = [];
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $options[$date->format('Y-m')] = $date->format('F Y');
        }
        return $options;
    }
}
