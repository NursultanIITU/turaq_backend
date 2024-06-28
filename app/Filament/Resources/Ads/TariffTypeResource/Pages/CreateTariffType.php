<?php

namespace App\Filament\Resources\Ads\TariffTypeResource\Pages;

use App\Filament\Resources\Ads\TariffTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTariffType extends CreateRecord
{
    protected static string $resource = TariffTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
