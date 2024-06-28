<?php

namespace App\Filament\Resources\Ads;

use AdminKit\Core\Forms\Components\TranslatableTabs;
use App\Filament\Resources\Ads\ObjectTypeResource\Pages;
use App\Models\Ads\ObjectType;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ObjectTypeResource extends Resource
{
    protected static ?string $model = ObjectType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableTabs::make(fn ($locale) => [
                    TextInput::make("title.$locale")
                        ->label(__('object_type.resource.title'))
                        ->required($locale === app()->getLocale()),
                    Toggle::make('is_active')
                        ->columnSpan('full')
                        ->label(__('object_type.resource.is_active')),
                ])->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('object_type.resource.id')),
                TextColumn::make('title')
                    ->limit(50)
                    ->sortable()
                    ->searchable()
                    ->label(__('object_type.resource.title')),
                IconColumn::make('is_active')
                    ->boolean()
                    ->alignCenter()
                    ->label(__('object_type.resource.is_active')),
                TextColumn::make('created_at')
                    ->label(__('object_type.resource.created_at')),
                TextColumn::make('updated_at')
                    ->label(__('object_type.resource.updated_at'))
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
            'index' => Pages\ListObjectTypes::route('/'),
            'create' => Pages\CreateObjectType::route('/create'),
            'edit' => Pages\EditObjectType::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        return __('object_type.resource.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('object_type.resource.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('advertisement.resource.directory_group');
    }
}
