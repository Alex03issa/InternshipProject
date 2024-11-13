<x-filament-widgets::widget>
    <x-filament::section>
        <div class="widget-container">
            <h3>Unlocked Backgrounds</h3>
            <div class="unlocked-items-grid backgrounds-grid">
                @foreach($backgrounds as $background)
                    <div class="unlocked-item">
                        <img src="{{ asset('storage/' . $background->background_image) }}" alt="{{ $background->background_name }}">
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>