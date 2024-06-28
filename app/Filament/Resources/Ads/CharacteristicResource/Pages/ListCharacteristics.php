<?php

namespace App\Filament\Resources\Ads\CharacteristicResource\Pages;

use App\Filament\Resources\Ads\CharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCharacteristics extends ListRecords
{
    protected static string $resource = CharacteristicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
