<x-filament-widgets::widget>
    <x-filament::section>
        <div class="widget-container">
            <h3>Your Unlocked Skins</h3>
            <div class="unlocked-items-grid skins-grid">
                @foreach($skins as $skin)
                    <div class="unlocked-item">
                        <img src="{{ asset('storage/' . $skin) }}" alt="Skin Image">
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>