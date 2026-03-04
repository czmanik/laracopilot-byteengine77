<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Akce';
    protected static ?string $modelLabel = 'Akce';
    protected static ?string $pluralModelLabel = 'Akce';
    protected static ?string $navigationGroup = 'Správa akcí';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Základní informace')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Název akce')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('URL slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('type')
                    ->label('Typ akce')
                    ->options([
                        'zizkovska_noc' => 'Žižkovská noc',
                        'mezidvorky'    => 'Žižkovské mezidvorky',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Popis')
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Termín a nastavení')->schema([
                Forms\Components\DatePicker::make('date_from')
                    ->label('Datum zahájení')
                    ->required(),
                Forms\Components\DatePicker::make('date_to')
                    ->label('Datum ukončení')
                    ->required(),
                Forms\Components\Toggle::make('is_paid')
                    ->label('Placená akce (vstupné)'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktivní')
                    ->default(true),
                Forms\Components\ColorPicker::make('primary_color')
                    ->label('Primární barva'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Název')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Typ')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'zizkovska_noc' => 'Žižkovská noc',
                        'mezidvorky'    => 'Mezidvorky',
                        default         => $state,
                    }),
                Tables\Columns\TextColumn::make('date_from')
                    ->label('Od')
                    ->date('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_to')
                    ->label('Do')
                    ->date('d.m.Y'),
                Tables\Columns\IconColumn::make('is_paid')
                    ->label('Vstupné')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktivní')
                    ->boolean(),
                Tables\Columns\TextColumn::make('places_count')
                    ->label('Míst')
                    ->counts('places'),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}