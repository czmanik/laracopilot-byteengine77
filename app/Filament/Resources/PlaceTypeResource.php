<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceTypeResource\Pages;
use App\Models\PlaceType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PlaceTypeResource extends Resource
{
    protected static ?string $model = PlaceType::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Typy míst';
    protected static ?string $modelLabel = 'Typ místa';
    protected static ?string $pluralModelLabel = 'Typy míst';
    protected static ?string $navigationGroup = 'Číselníky';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Název')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('icon')
                ->label('Ikona (heroicon název)')
                ->placeholder('heroicon-o-building-storefront'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Název')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
                Tables\Columns\TextColumn::make('places_count')->label('Míst')->counts('places'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlaceTypes::route('/'),
            'create' => Pages\CreatePlaceType::route('/create'),
            'edit'   => Pages\EditPlaceType::route('/{record}/edit'),
        ];
    }
}