<?php

namespace App\Filament\Resources\AdsResource\Pages;

use App\Filament\Resources\AdsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAds extends EditRecord
{
    protected static string $resource = AdsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('view_ads')
                ->label('View Ads')
                ->url(AdsResource::getUrl('index'))
                ->icon('heroicon-o-user-group'),
        ];
    }
}
