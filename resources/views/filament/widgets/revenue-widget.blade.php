<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/widgets.css') }}">
</head>

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Total Revenue Card -->
            <div class="widget revenue-widget">
                <div class="widget-header">
                    <i class="fas fa-dollar-sign widget-icon"></i>
                    <h2>Total Revenue</h2>
                </div>
                <p class="widget-value">{{ '$' . number_format($totalRevenue, 2) }}</p>
            </div>

            <!-- Pending Bills Card -->
            <div class="widget pending-widget">
                <div class="widget-header">
                    <i class="fas fa-file-invoice-dollar widget-icon"></i>
                    <h2>Pending Bills</h2>
                </div>
                <p class="widget-value">{{ '$' . number_format($pendingBills, 2) }}</p>
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
