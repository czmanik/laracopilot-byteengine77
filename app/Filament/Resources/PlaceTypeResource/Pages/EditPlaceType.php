<?php

namespace App\Filament\Resources\PlaceTypeResource\Pages;

use App\Filament\Resources\PlaceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlaceType extends EditRecord
{
    protected static string $resource = PlaceTypeResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}