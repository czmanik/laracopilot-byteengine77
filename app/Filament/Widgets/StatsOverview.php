<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Place;
use App\Models\ProgramSlot;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Aktivní akce', Event::where('is_active', true)->count())
                ->description('Celkem akcí: ' . Event::count())
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('Místa', Place::where('status', 'approved')->count())
                ->description(Place::where('status', 'pending')->count() . ' čeká na schválení')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('success'),

            Stat::make('Programové sloty', ProgramSlot::where('status', 'published')->count())
                ->description('Celkem: ' . ProgramSlot::count())
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Uživatelé', User::where('is_active', true)->count())
                ->description('Správci míst: ' . User::where('role', 'place_manager')->count())
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}