<?php

namespace App\Filament\Resources\Ads\ParkingSpaceSizeResource\Pages;

use App\Filament\Resources\Ads\ParkingSpaceSizeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateParkingSpaceSize extends CreateRecord
{
    protected static string $resource = ParkingSpaceSizeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
