<?php

namespace App\Filament\Resources\Ads\ObjectTypeResource\Pages;

use App\Filament\Resources\Ads\ObjectTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObjectType extends EditRecord
{
    protected static string $resource = ObjectTypeResource::class;

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
