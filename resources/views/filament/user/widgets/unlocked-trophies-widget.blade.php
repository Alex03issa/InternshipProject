<x-filament-widgets::widget>
    <x-filament::section>
        <div class="widget-container">
            <h3>Unlocked Trophies</h3>
            <div class="unlocked-items-grid trophies-grid">
                @foreach($trophies as $trophy)
                    <div class="unlocked-item">
                        <img src="{{ asset('storage/' . $trophy['icon']) }}" alt="Trophy Image">
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>