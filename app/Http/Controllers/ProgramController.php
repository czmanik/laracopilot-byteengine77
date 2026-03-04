<?php

namespace App\Http\Controllers;

use App\Models\ProgramSlot;
use App\Models\Place;
use App\Models\ActivityCategory;
use App\Models\Event;

class ProgramController extends Controller
{
    public function index()
    {
        $activeEvent = Event::where('is_active', true)->latest()->first();

        $categories = ActivityCategory::whereHas('programSlots', fn ($q) =>
            $q->where('status', 'published')
        )->get();

        $places = Place::where('status', 'approved')
            ->when($activeEvent, fn ($q) => $q->where('event_id', $activeEvent->id))
            ->pluck('name', 'id');

        $slots = ProgramSlot::where('status', 'published')
            ->with(['place', 'stage', 'activityCategory'])
            ->when(request('category'), fn ($q) => $q->where('activity_category_id', request('category')))
            ->when(request('place'), fn ($q) => $q->where('place_id', request('place')))
            ->when(request('day'), fn ($q) => $q->whereDate('starts_at', request('day')))
            ->orderBy('starts_at')
            ->paginate(20);

        return view('program.index', compact('slots', 'categories', 'places', 'activeEvent'));
    }
}