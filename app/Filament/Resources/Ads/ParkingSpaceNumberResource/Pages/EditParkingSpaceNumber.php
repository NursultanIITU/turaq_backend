<?php

namespace App\Filament\Resources\Ads\ParkingSpaceNumberResource\Pages;

use App\Filament\Resources\Ads\ParkingSpaceNumberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParkingSpaceNumber extends EditRecord
{
    protected static string $resource = ParkingSpaceNumberResource::class;

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
