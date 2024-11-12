<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\GameStatistic;
use App\Models\GameUserStatistic;

class DownloadStatisticsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Download Statistics by Platform';

    // Set the chart type to 'radar'
    protected function getType(): string
    {
        return 'radar';
    }

    // Define the fixed size of the chart
    protected function getHeight(): int
    {
        return 300; // Fixed height to maintain consistency across reloads
    }

    protected function getData(): array
    {
        // Retrieve data from your models or set static values for demonstration
        $totalActiveUsers = GameStatistic::first()->total_active_users ?? 0;
        $totalActiveGuests = GameStatistic::first()->total_active_guests ?? 0;

        $playStoreDownloads = GameUserStatistic::where('platform', 'play_store')->count();
        $appStoreDownloads = GameUserStatistic::where('platform', 'app_store')->count();

        return [
            'labels' => ['Total Downloads', 'Active Users', 'Guests'],
            'datasets' => [
                [
                    'label' => 'Play Store',
                    'backgroundColor' => 'rgba(34, 202, 236, 0.5)',
                    'borderColor' => 'rgba(34, 202, 236, 1)',
                    'data' => [$playStoreDownloads, $totalActiveUsers, $totalActiveGuests],
                ],
                [
                    'label' => 'App Store',
                    'backgroundColor' => 'rgba(153, 102, 255, 0.5)',
                    'borderColor' => 'rgba(153, 102, 255, 1)',
                    'data' => [$appStoreDownloads, $totalActiveUsers, $totalActiveGuests],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'r' => [
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.1)',
                    ],
                    'angleLines' => [
                        'color' => 'rgba(255, 255, 255, 0.1)',
                    ],
                    'ticks' => [
                        'color' => 'gray', 
                        'backdropColor' => 'rgba(0, 0, 0, 0)', // Transparent backdrop
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => '#FFFFFF', // White color for legend text
                    ],
                ],
            ],
        ];
    }

}
