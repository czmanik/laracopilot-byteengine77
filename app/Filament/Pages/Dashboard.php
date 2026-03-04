<?php

namespace App\Filament\Pages;

use App\Models\Event;
use App\Models\Place;
use App\Models\ProgramSlot;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Přehled';
    protected static ?string $title = 'Přehled systému';
}