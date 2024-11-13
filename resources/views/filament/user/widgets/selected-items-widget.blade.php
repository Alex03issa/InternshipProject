<x-filament-widgets::widget>
    <x-filament::section>
        <div class="widget-container ">
            <div class="selected-items-grid ">
                
                <!-- Selected Background -->
                <h3 class="text-lg font-semibold">Selected Background</h3>
                <div class="selected-item selected-background">
                    
                    @if($selectedBackground)
                        <img src="{{ asset('storage/' . $selectedBackground) }}" alt="Selected Background">
                    @else
                        <p>No background selected.</p>
                    @endif
                </div>
                
                <!-- Selected Skin -->
                <h3 class="text-lg font-semibold">Selected Skin</h3>
                <div class="selected-item selected-skin">
                    
                    @if($selectedSkin)
                        <img src="{{ asset('storage/' . $selectedSkin) }}" alt="Selected Skin">
                    @else
                        <p>No skin selected.</p>
                    @endif
                </div>

            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>