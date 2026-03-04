<?php

namespace App\Filament\Resources\PlaceTypeResource\Pages;

use App\Filament\Resources\PlaceTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlaceType extends CreateRecord
{
    protected static string $resource = PlaceTypeResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}