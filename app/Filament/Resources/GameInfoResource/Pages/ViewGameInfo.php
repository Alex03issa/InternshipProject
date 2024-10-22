<?php

namespace App\Filament\Resources\GameInfoResource\Pages;

use App\Filament\Resources\GameInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGameInfo extends ViewRecord
{
    protected static string $resource = GameInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
