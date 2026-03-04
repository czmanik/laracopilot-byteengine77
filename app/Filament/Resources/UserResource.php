<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Uživatelé';
    protected static ?string $modelLabel = 'Uživatel';
    protected static ?string $pluralModelLabel = 'Uživatelé';
    protected static ?string $navigationGroup = 'Administrace';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Jméno')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label('Heslo')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context) => $context === 'create')
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options([
                        'super_admin'   => 'Super Admin',
                        'admin'         => 'Admin',
                        'place_manager' => 'Správce místa',
                    ])
                    ->required()
                    ->default('place_manager'),
                Forms\Components\Select::make('place_id')
                    ->label('Přiřazené místo')
                    ->options(Place::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
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
                Tables\Columns\TextColumn::make('name')->label('Jméno')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('E-mail')->searchable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->label('Role')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'super_admin'   => 'Super Admin',
                        'admin'         => 'Admin',
                        'place_manager' => 'Správce místa',
                        default         => $state,
                    })
                    ->colors([
                        'danger'  => 'super_admin',
                        'warning' => 'admin',
                        'primary' => 'place_manager',
                    ]),
                Tables\Columns\TextColumn::make('place.name')->label('Místo')->badge(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktivní')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('Vytvořen')->date('d.m.Y')->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}