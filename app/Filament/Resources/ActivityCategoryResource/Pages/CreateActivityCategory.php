<?php

namespace App\Filament\Resources\ActivityCategoryResource\Pages;

use App\Filament\Resources\ActivityCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateActivityCategory extends CreateRecord
{
    protected static string $resource = ActivityCategoryResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}