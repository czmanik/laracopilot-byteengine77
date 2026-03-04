<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccessibilityOptionResource\Pages;
use App\Models\AccessibilityOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AccessibilityOptionResource extends Resource
{
    protected static ?string $model = AccessibilityOption::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Dostupnost';
    protected static ?string $modelLabel = 'Dostupnost';
    protected static ?string $pluralModelLabel = 'Dostupnost';
    protected static ?string $navigationGroup = 'Číselníky';
    protected static ?int $navigationSort = 12;

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
                ->label('Ikona'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Název')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAccessibilityOptions::route('/'),
            'create' => Pages\CreateAccessibilityOption::route('/create'),
            'edit'   => Pages\EditAccessibilityOption::route('/{record}/edit'),
        ];
    }
}