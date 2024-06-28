<?php

namespace App\Filament\Resources\Ads\ParkingSpaceNumberResource\Pages;

use App\Filament\Resources\Ads\ParkingSpaceNumberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParkingSpaceNumbers extends ListRecords
{
    protected static string $resource = ParkingSpaceNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
