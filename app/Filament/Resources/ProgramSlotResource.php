<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramSlotResource\Pages;
use App\Models\ProgramSlot;
use App\Models\Place;
use App\Models\Stage;
use App\Models\ActivityCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProgramSlotResource extends Resource
{
    protected static ?string $model = ProgramSlot::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Program';
    protected static ?string $modelLabel = 'Programový slot';
    protected static ?string $pluralModelLabel = 'Program';
    protected static ?string $navigationGroup = 'Správa akcí';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Místo a stage')->schema([
                Forms\Components\Select::make('place_id')
                    ->label('Místo')
                    ->options(Place::where('status', 'approved')->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('stage_id', null)),
                Forms\Components\Select::make('stage_id')
                    ->label('Stage')
                    ->options(fn (Forms\Get $get) =>
                        Stage::where('place_id', $get('place_id'))->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('activity_category_id')
                    ->label('Typ aktivity')
                    ->options(ActivityCategory::pluck('name', 'id'))
                    ->searchable(),
            ])->columns(3),

            Forms\Components\Section::make('Popis')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Název')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('performer')
                    ->label('Interpret / Účinkující')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Popis')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('Obrázek')
                    ->image()
                    ->directory('program'),
            ])->columns(2),

            Forms\Components\Section::make('Čas a stav')->schema([
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Začátek')
                    ->required()
                    ->seconds(false),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Konec')
                    ->required()
                    ->seconds(false),
                Forms\Components\Select::make('status')
                    ->label('Stav')
                    ->options([
                        'draft'     => 'Koncept',
                        'published' => 'Publikováno',
                        'cancelled' => 'Zrušeno',
                    ])
                    ->default('draft')
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Pořadí')
                    ->numeric()
                    ->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Začátek')
                    ->dateTime('d.m. H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Konec')
                    ->dateTime('H:i'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Název')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('performer')
                    ->label('Interpret')
                    ->searchable(),
                Tables\Columns\TextColumn::make('place.name')
                    ->label('Místo')
                    ->badge(),
                Tables\Columns\TextColumn::make('stage.name')
                    ->label('Stage'),
                Tables\Columns\TextColumn::make('activityCategory.name')
                    ->label('Typ')
                    ->badge(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Stav')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'published' => 'Publikováno',
                        'cancelled' => 'Zrušeno',
                        default     => 'Koncept',
                    })
                    ->colors([
                        'success' => 'published',
                        'danger'  => 'cancelled',
                        'warning' => 'draft',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('place_id')
                    ->label('Místo')
                    ->options(Place::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Stav')
                    ->options([
                        'draft'     => 'Koncept',
                        'published' => 'Publikováno',
                        'cancelled' => 'Zrušeno',
                    ]),
                Tables\Filters\SelectFilter::make('activity_category_id')
                    ->label('Typ aktivity')
                    ->options(ActivityCategory::pluck('name', 'id')),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('starts_at');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProgramSlots::route('/'),
            'create' => Pages\CreateProgramSlot::route('/create'),
            'edit'   => Pages\EditProgramSlot::route('/{record}/edit'),
        ];
    }
}