<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityCategoryResource\Pages;
use App\Models\ActivityCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ActivityCategoryResource extends Resource
{
    protected static ?string $model = ActivityCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Typy aktivit';
    protected static ?string $modelLabel = 'Typ aktivity';
    protected static ?string $pluralModelLabel = 'Typy aktivit';
    protected static ?string $navigationGroup = 'Číselníky';
    protected static ?int $navigationSort = 11;

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
            Forms\Components\ColorPicker::make('color')
                ->label('Barva'),
            Forms\Components\TextInput::make('icon')
                ->label('Ikona'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')->label('Barva'),
                Tables\Columns\TextColumn::make('name')->label('Název')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListActivityCategories::route('/'),
            'create' => Pages\CreateActivityCategory::route('/create'),
            'edit'   => Pages\EditActivityCategory::route('/{record}/edit'),
        ];
    }
}