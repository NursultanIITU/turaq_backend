<?php

namespace App\Filament\Resources\Ads\ObjectTypeResource\Pages;

use App\Filament\Resources\Ads\ObjectTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListObjectTypes extends ListRecords
{
    protected static string $resource = ObjectTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
