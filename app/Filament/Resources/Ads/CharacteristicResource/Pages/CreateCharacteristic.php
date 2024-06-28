<?php

namespace App\Filament\Resources\Ads\CharacteristicResource\Pages;

use App\Filament\Resources\Ads\CharacteristicResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCharacteristic extends CreateRecord
{
    protected static string $resource = CharacteristicResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
