<?php

namespace App\Filament\Resources\ProgramSlotResource\Pages;

use App\Filament\Resources\ProgramSlotResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgramSlot extends CreateRecord
{
    protected static string $resource = ProgramSlotResource::class;
    protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); }
}