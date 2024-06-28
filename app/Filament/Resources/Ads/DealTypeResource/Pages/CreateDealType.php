<?php

namespace App\Filament\Resources\Ads\DealTypeResource\Pages;

use App\Filament\Resources\Ads\DealTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDealType extends CreateRecord
{
    protected static string $resource = DealTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
