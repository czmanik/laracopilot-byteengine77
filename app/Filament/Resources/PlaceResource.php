<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Place;
use App\Models\Event;
use App\Models\PlaceType;
use App\Models\Organizer;
use App\Models\AccessibilityOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Místa';
    protected static ?string $modelLabel = 'Místo';
    protected static ?string $pluralModelLabel = 'Místa';
    protected static ?string $navigationGroup = 'Správa akcí';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Základní informace')->schema([
                Forms\Components\Select::make('event_id')
                    ->label('Akce')
                    ->options(Event::pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('place_type_id')
                    ->label('Typ místa')
                    ->options(PlaceType::pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('organizer_id')
                    ->label('Zodpovědná osoba')
                    ->options(Organizer::where('is_active', true)->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('name')
                    ->label('Název místa')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->label('URL slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->label('Popis místa')
                    ->rows(4)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Kontakt a adresa')->schema([
                Forms\Components\TextInput::make('address')
                    ->label('Adresa')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('city')
                    ->label('Město')
                    ->default('Praha'),
                Forms\Components\TextInput::make('lat')
                    ->label('GPS šířka (lat)')
                    ->numeric(),
                Forms\Components\TextInput::make('lng')
                    ->label('GPS délka (lng)')
                    ->numeric(),
                Forms\Components\TextInput::make('website')
                    ->label('Web')
                    ->url(),
                Forms\Components\TextInput::make('facebook')
                    ->label('Facebook URL'),
                Forms\Components\TextInput::make('instagram')
                    ->label('Instagram URL'),
            ])->columns(3),

            Forms\Components\Section::make('Program – časový rámec')->schema([
                Forms\Components\DateTimePicker::make('program_from')
                    ->label('Program od')
                    ->seconds(false),
                Forms\Components\DateTimePicker::make('program_to')
                    ->label('Program do')
                    ->seconds(false),
            ])->columns(2),

            Forms\Components\Section::make('Fotografie')->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->label('Úvodní fotka')
                    ->image()
                    ->directory('places/covers'),
                Forms\Components\FileUpload::make('photos')
                    ->label('Galerie')
                    ->image()
                    ->multiple()
                    ->directory('places/gallery')
                    ->reorderable(),
            ])->columns(2),

            Forms\Components\Section::make('Dostupnost a stav')->schema([
                Forms\Components\CheckboxList::make('accessibilityOptions')
                    ->label('Dostupnost')
                    ->relationship('accessibilityOptions', 'name')
                    ->columns(3)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Stav schválení')
                    ->options([
                        'pending'  => 'Čeká na schválení',
                        'approved' => 'Schváleno',
                        'rejected' => 'Zamítnuto',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktivní')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Pořadí')
                    ->numeric()
                    ->default(0),
            ])->columns(3),

            Forms\Components\Section::make('Stage (pódium/místnosti)')->schema([
                Forms\Components\Repeater::make('stages')
                    ->label('Stage')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Název stage')
                            ->required(),
                        Forms\Components\TextInput::make('capacity')
                            ->label('Kapacita')
                            ->numeric(),
                        Forms\Components\Textarea::make('description')
                            ->label('Popis')
                            ->rows(2),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Pořadí')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2)
                    ->addActionLabel('Přidat stage')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Název')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.name')
                    ->label('Akce')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('placeType.name')
                    ->label('Typ')
                    ->badge(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Adresa')
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Stav')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'approved' => 'Schváleno',
                        'rejected' => 'Zamítnuto',
                        default    => 'Čeká',
                    })
                    ->colors([
                        'success' => 'approved',
                        'danger'  => 'rejected',
                        'warning' => 'pending',
                    ]),
                Tables\Columns\IconColumn::make('is_active')->label('Aktivní')->boolean(),
                Tables\Columns\TextColumn::make('stages_count')->label('Stage')->counts('stages'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event_id')
                    ->label('Akce')
                    ->options(Event::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Stav')
                    ->options([
                        'pending'  => 'Čeká na schválení',
                        'approved' => 'Schváleno',
                        'rejected' => 'Zamítnuto',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Schválit')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (Place $record) => $record->update(['status' => 'approved']))
                    ->visible(fn (Place $record) => $record->status === 'pending'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'edit'   => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}