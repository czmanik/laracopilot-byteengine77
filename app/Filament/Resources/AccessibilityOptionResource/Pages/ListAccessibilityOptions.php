<?php

namespace App\Filament\Resources\AccessibilityOptionResource\Pages;

use App\Filament\Resources\AccessibilityOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccessibilityOptions extends ListRecords
{
    protected static string $resource = AccessibilityOptionResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()->label('Přidat dostupnost')]; }
}