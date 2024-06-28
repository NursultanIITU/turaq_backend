<?php

namespace App\Filament\Resources\Ads\CityResource\Pages;

use App\Filament\Resources\Ads\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
