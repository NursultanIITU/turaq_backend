<?php

namespace App\Filament\Resources\Ads;

use AdminKit\Core\Forms\Components\TranslatableTabs;
use App\Filament\Resources\Ads\CityResource\Pages;
use App\Models\Ads\City;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableTabs::make(fn ($locale) => [
                    TextInput::make("name.$locale")
                        ->label(__('city.resource.title'))
                        ->required($locale === app()->getLocale()),
                    Toggle::make('is_active')
                        ->columnSpan('full')
                        ->label(__('city.resource.is_active')),
                ])->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('city.resource.id')),
                TextColumn::make('name')
                    ->limit(50)
                    ->sortable()
                    ->searchable()
                    ->label(__('city.resource.title')),
                IconColumn::make('is_active')
                    ->boolean()
                    ->alignCenter()
                    ->label(__('city.resource.is_active')),
                TextColumn::make('created_at')
                    ->label(__('city.resource.created_at')),
                TextColumn::make('updated_at')
                    ->label(__('city.resource.updated_at'))
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        return __('city.resource.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('city.resource.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('advertisement.resource.navigation_group');
    }
}
