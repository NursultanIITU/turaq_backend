<?php

namespace App\Filament\Resources\Ads\DealTypeResource\Pages;

use App\Filament\Resources\Ads\DealTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDealTypes extends ListRecords
{
    protected static string $resource = DealTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
