<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label(trans('users.resource.name')),
                TextInput::make('surname')->required()->label(trans('users.resource.surname')),
                TextInput::make('phone')->unique(ignoreRecord: true)->required()->label(trans('users.resource.phone')),
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('images')
                    ->image()
                    ->columnSpan('full')
                    ->required()
                    ->label(__('users.resource.image')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label(trans('users.resource.id')),
                TextColumn::make('phone')->sortable()->searchable()->label(trans('users.resource.phone')),
                TextColumn::make('name')->sortable()->searchable()->label(trans('users.resource.name')),
                TextColumn::make('surname')->sortable()->searchable()->label(trans('users.resource.surname')),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('images')
                    ->alignCenter()
                    ->label(__('users.resource.image')),
                TextColumn::make('created_at')
                    ->label(__('users.resource.created_at')),
                TextColumn::make('updated_at')
                    ->label(__('users.resource.updated_at'))
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        return __('users.resource.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('users.resource.plural_label');
    }
}
