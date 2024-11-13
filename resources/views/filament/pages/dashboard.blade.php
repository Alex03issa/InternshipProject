<div class="p-3">
    <!-- Full-width section for Revenue and Pending Bills -->
    <div class="grid-cols-2">
        <!-- Total Revenue Widget -->
        <div class="p-3 col-span-6">
            @livewire(\App\Filament\Widgets\RevenueWidget::class)
        </div>

    </div>

    <!-- Main Widgets with Tighter Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Monthly Registered Users Widget -->
        <div class="p-3 bg-gray-900 rounded-lg shadow-lg w-full">
            @livewire(\App\Filament\Widgets\MonthlyRegisteredUsers::class)
        </div>

        <!-- Revenue and Bills per Month Widget -->
        <div class="p-3 bg-gray-900 rounded-lg shadow-lg w-full">
            @livewire(\App\Filament\Widgets\MonthlyRevenueChart::class)
        </div>
    </div>

    <!-- Centered Monthly Active Users vs Guests and Separate Row for Download Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <!-- Monthly Active Users vs Guests centered -->
        <div class="p-3 bg-gray-900 rounded-lg shadow-lg w-full mx-auto">
            @livewire(\App\Filament\Widgets\MonthlyUserGuestChart::class)
        </div>

        <!-- Download Statistics by Platform in full width on a new row -->
        <div class="p-3 bg-gray-900 rounded-lg shadow-lg w-full mx-auto">
            @livewire(\App\Filament\Widgets\DownloadStatisticsChartWidget::class)
        </div>
    </div>
</div>
