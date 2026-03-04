<?php

namespace App\Filament\Resources\AccessibilityOptionResource\Pages;

use App\Filament\Resources\AccessibilityOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessibilityOption extends EditRecord
{
    protected static string $resource = AccessibilityOptionResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}