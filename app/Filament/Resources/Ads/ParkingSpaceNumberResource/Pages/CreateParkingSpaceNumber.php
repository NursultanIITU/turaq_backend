<?php

namespace App\Filament\Resources\Ads\ParkingSpaceNumberResource\Pages;

use App\Filament\Resources\Ads\ParkingSpaceNumberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateParkingSpaceNumber extends CreateRecord
{
    protected static string $resource = ParkingSpaceNumberResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
