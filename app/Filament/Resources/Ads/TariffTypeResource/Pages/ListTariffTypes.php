<?php

namespace App\Filament\Resources\Ads\TariffTypeResource\Pages;

use App\Filament\Resources\Ads\TariffTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTariffTypes extends ListRecords
{
    protected static string $resource = TariffTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
