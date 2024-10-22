<?php

namespace App\Filament\Resources\GameInfoResource\Pages;

use App\Filament\Resources\GameInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGameInfos extends ListRecords
{
    protected static string $resource = GameInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
