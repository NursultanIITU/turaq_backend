<?php

namespace App\Filament\Resources\Ads\ParkingTypeResource\Pages;

use App\Filament\Resources\Ads\ParkingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParkingTypes extends ListRecords
{
    protected static string $resource = ParkingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
