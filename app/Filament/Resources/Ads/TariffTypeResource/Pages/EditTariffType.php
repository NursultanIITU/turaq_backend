<?php

namespace App\Filament\Resources\Ads\TariffTypeResource\Pages;

use App\Filament\Resources\Ads\TariffTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTariffType extends EditRecord
{
    protected static string $resource = TariffTypeResource::class;

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
