<?php

namespace App\Filament\Resources\Ads\ParkingSpaceSizeResource\Pages;

use App\Filament\Resources\Ads\ParkingSpaceSizeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParkingSpaceSize extends EditRecord
{
    protected static string $resource = ParkingSpaceSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
