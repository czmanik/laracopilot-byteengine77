<?php

namespace App\Filament\Resources\PlaceTypeResource\Pages;

use App\Filament\Resources\PlaceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaceTypes extends ListRecords
{
    protected static string $resource = PlaceTypeResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()->label('Přidat typ')]; }
}