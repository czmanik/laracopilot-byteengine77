<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizerResource\Pages;
use App\Models\Organizer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrganizerResource extends Resource
{
    protected static ?string $model = Organizer::class;
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Organizátoři';
    protected static ?string $modelLabel = 'Organizátor';
    protected static ?string $pluralModelLabel = 'Organizátoři';
    protected static ?string $navigationGroup = 'Správa akcí';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Jméno a příjmení')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefon')
                    ->tel(),
                Forms\Components\Textarea::make('bio')
                    ->label('Bio / Popis')
                    ->rows(3),
                Forms\Components\FileUpload::make('avatar')
                    ->label('Fotografie')
                    ->image()
                    ->directory('organizers'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktivní')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Jméno')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('E-mail')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telefon'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktivní')->boolean(),
                Tables\Columns\TextColumn::make('places_count')->label('Míst')->counts('places'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrganizers::route('/'),
            'create' => Pages\CreateOrganizer::route('/create'),
            'edit'   => Pages\EditOrganizer::route('/{record}/edit'),
        ];
    }
}