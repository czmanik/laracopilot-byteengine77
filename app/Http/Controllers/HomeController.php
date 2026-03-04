<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Place;
use App\Models\ProgramSlot;

class HomeController extends Controller
{
    public function index()
    {
        $activeEvent = Event::where('is_active', true)->latest()->first();

        $places = Place::where('status', 'approved')
            ->where('is_active', true)
            ->with(['placeType', 'stages'])
            ->when($activeEvent, fn ($q) => $q->where('event_id', $activeEvent->id))
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get();

        $upcomingSlots = ProgramSlot::where('status', 'published')
            ->where('starts_at', '>=', now())
            ->with(['place', 'stage', 'activityCategory'])
            ->orderBy('starts_at')
            ->limit(6)
            ->get();

        return view('home', compact('activeEvent', 'places', 'upcomingSlots'));
    }
}