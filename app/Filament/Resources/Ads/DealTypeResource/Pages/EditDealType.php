<?php

namespace App\Filament\Resources\Ads\DealTypeResource\Pages;

use App\Filament\Resources\Ads\DealTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDealType extends EditRecord
{
    protected static string $resource = DealTypeResource::class;

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
