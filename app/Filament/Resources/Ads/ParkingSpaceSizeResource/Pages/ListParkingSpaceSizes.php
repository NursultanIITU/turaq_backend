<?php

namespace App\Filament\Resources\Ads\ParkingSpaceSizeResource\Pages;

use App\Filament\Resources\Ads\ParkingSpaceSizeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParkingSpaceSizes extends ListRecords
{
    protected static string $resource = ParkingSpaceSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
