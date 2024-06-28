<?php

namespace App\Filament\Resources\Ads;

use App\Enums\AdvertisementStatusEnum;
use App\Filament\Resources\Ads\AdvertisementResource\Pages;
use App\Models\Ads\Advertisement;
use App\Models\Ads\DealType;
use App\Models\Ads\ObjectType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                        if ($operation !== 'create') {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    })
                                    ->label(__('advertisement.resource.name')),

                                TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Advertisement::class, 'slug', ignoreRecord: true),

                                Select::make('city_id')
                                    ->relationship(name: 'city', titleAttribute: 'name->'.app()->getLocale())
                                    ->searchable()
                                    ->native(false)
                                    ->preload()
                                    ->required()
                                    ->columnSpan('full')
                                    ->label(__('advertisement.resource.city_id')),

                                TextInput::make('latitude')
                                    ->required()
                                    ->numeric()
                                    ->label(__('advertisement.resource.latitude')),

                                TextInput::make('longitude')
                                    ->required()
                                    ->numeric()
                                    ->label(__('advertisement.resource.longitude')),

                                MarkdownEditor::make('description')
                                    ->columnSpan('full')
                                    ->label(__('advertisement.resource.description')),
                            ])
                            ->columns(2),

                        Section::make('Inventory')
                            ->schema([
                                ToggleButtons::make('object_type_id')
                                    ->inline()
                                    ->grouped()
                                    ->label(__('advertisement.resource.object_type_id'))
                                    ->options(ObjectType::where('is_active', true)->pluck('title', 'id')),

                                ToggleButtons::make('deal_type_id')
                                    ->inline()
                                    ->grouped()
                                    ->label(__('advertisement.resource.deal_type_id'))
                                    ->options(DealType::where('is_active', true)->pluck('title', 'id')),

                                Select::make('tariff_type_id')
                                    ->relationship(name: 'tariffType', titleAttribute: 'title->'.app()->getLocale())
                                    ->searchable()
                                    ->native(false)
                                    ->preload()
                                    ->label(__('advertisement.resource.tariff_type_id')),

                                Select::make('parking_type_id')
                                    ->relationship(name: 'parkingType', titleAttribute: 'title->'.app()->getLocale())
                                    ->searchable()
                                    ->native(false)
                                    ->preload()
                                    ->label(__('advertisement.resource.parking_type_id')),

                                Select::make('parking_space_size_id')
                                    ->relationship(name: 'parkingSpaceSize', titleAttribute: 'title->'.app()->getLocale())
                                    ->searchable()
                                    ->native(false)
                                    ->preload()
                                    ->label(__('advertisement.resource.parking_space_size_id')),
                            ])
                            ->columns(2),

                        Section::make(__('advertisement.resource.cost'))
                            ->schema([
                                TextInput::make('price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,10}(\.\d{0,2})?$/'])
                                    ->required()
                                    ->label(__('advertisement.resource.price')),

                                TextInput::make('area')
                                    ->label('Compare at price')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required()
                                    ->label(__('advertisement.resource.area')),

                                Select::make('parking_space_number_id')
                                    ->relationship(name: 'parkingSpaceNumber', titleAttribute: 'title->'.app()->getLocale())
                                    ->searchable()
                                    ->native(false)
                                    ->preload()
                                    ->required()
                                    ->label(__('advertisement.resource.parking_space_number_id')),

                                Select::make('characteristic_id')
                                    ->relationship('characteristics')
                                    ->multiple()
                                    ->preload()
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->title}")
                                    ->label(__('advertisement.resource.characteristics'))
                                    ->minItems(1)
                                    ->required(),

                            ])
                            ->columns(2),

                        Section::make(__('advertisement.resource.images'))
                            ->description(__('advertisement.resource.images_description'))
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->collection('images')
                                    ->multiple()
                                    ->image()
                                    ->maxFiles(5)
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make(__('advertisement.resource.information'))
                            ->schema([
                                ToggleButtons::make('status')
                                    ->inline()
                                    ->label(__('advertisement.resource.status'))
                                    ->options(AdvertisementStatusEnum::class)
                                    ->required(),

                                Select::make('user_id')
                                    ->relationship('user', 'phone')
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->label(__('advertisement.resource.user')),

                                DateTimePicker::make('created_at')
                                    ->native(false)
                                    ->label(__('advertisement.resource.created_at'))
                                    ->default(now())
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('advertisement.resource.id')),
                TextColumn::make('name')
                    ->limit(50)
                    ->sortable()
                    ->alignCenter()
                    ->searchable(isIndividual: true)
                    ->label(__('advertisement.resource.name')),
                TextColumn::make('user.phone')
                    ->sortable()
                    ->searchable(isIndividual: true)
                    ->label(__('advertisement.resource.user')),
                TextColumn::make('price')
                    ->sortable()
                    ->alignCenter()
                    ->label(__('advertisement.resource.price')),
                TextColumn::make('area')
                    ->sortable()
                    ->alignCenter()
                    ->label(__('advertisement.resource.area')),
                SpatieMediaLibraryImageColumn::make('media')
                    ->circular()
                    ->stacked()
                    ->collection('images')
                    ->limit(5)
                    ->label(__('advertisement.resource.images')),
                TextColumn::make('status')
                    ->label(__('advertisement.resource.status'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->label(__('deal_type.resource.created_at')),
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
            'index' => Pages\ListAdvertisements::route('/'),
            'create' => Pages\CreateAdvertisement::route('/create'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        return __('advertisement.resource.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('advertisement.resource.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('advertisement.resource.navigation_group');
    }

    public static function getNavigationBadge(): ?string
    {
        $modelClass = static::$model;

        return (string) $modelClass::count();
    }
}
