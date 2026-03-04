<?php

namespace App\Filament\Resources\AccessibilityOptionResource\Pages;

use App\Filament\Resources\AccessibilityOptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccessibilityOption extends CreateRecord
{
    protected static string $resource = AccessibilityOptionResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}