<?php

namespace App\Filament\Resources\Ads\AdvertisementResource\Pages;

use App\Filament\Resources\Ads\AdvertisementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvertisements extends ListRecords
{
    protected static string $resource = AdvertisementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
