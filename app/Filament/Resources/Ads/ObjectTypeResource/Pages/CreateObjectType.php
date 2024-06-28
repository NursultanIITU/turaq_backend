<?php

namespace App\Filament\Resources\Ads\ObjectTypeResource\Pages;

use App\Filament\Resources\Ads\ObjectTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateObjectType extends CreateRecord
{
    protected static string $resource = ObjectTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
