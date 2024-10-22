<?php

namespace App\Filament\Resources\GameInfoResource\Pages;

use App\Filament\Resources\GameInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGameInfo extends EditRecord
{
    protected static string $resource = GameInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
