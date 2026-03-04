<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Event;
use App\Models\PlaceType;

class PlaceController extends Controller
{
    public function index()
    {
        $activeEvent = Event::where('is_active', true)->latest()->first();

        $placeTypes = PlaceType::whereHas('places', fn ($q) =>
            $q->where('status', 'approved')->where('is_active', true)
        )->get();

        $places = Place::where('status', 'approved')
            ->where('is_active', true)
            ->with(['placeType', 'organizer', 'stages', 'accessibilityOptions'])
            ->when($activeEvent, fn ($q) => $q->where('event_id', $activeEvent->id))
            ->when(request('type'), fn ($q) => $q->where('place_type_id', request('type')))
            ->orderBy('sort_order')
            ->paginate(12);

        return view('places.index', compact('places', 'placeTypes', 'activeEvent'));
    }

    public function show(string $slug)
    {
        $place = Place::where('slug', $slug)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->with([
                'placeType',
                'organizer',
                'stages.programSlots' => fn ($q) => $q->where('status', 'published')->orderBy('starts_at'),
                'stages.programSlots.activityCategory',
                'accessibilityOptions',
                'event',
            ])
            ->firstOrFail();

        return view('places.show', compact('place'));
    }
}