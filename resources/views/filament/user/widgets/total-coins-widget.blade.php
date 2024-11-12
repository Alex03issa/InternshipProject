
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/widgets.css') }}">
</head>

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="widget coins-widget">
            <div class="widget-header">
                <i class="fas fa-coins widget-icon"></i>
                <h2>Your Coins</h2>
            </div>
            <p class="widget-value">{{ $coin }}</p>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
