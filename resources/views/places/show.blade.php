@extends('layouts.app')
@section('title', $place->name . ' – Žižkovská noc & Mezidvorky 2026')

@section('content')
<!-- Hero místa -->
<div class="relative h-72 bg-gradient-to-br from-rose-700 to-orange-500 overflow-hidden">
    @if($place->cover_image)
    <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->name }}" class="w-full h-full object-cover opacity-60">
    @endif
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-6xl mx-auto px-4 pb-8 w-full">
            @if($place->placeType)
            <span class="bg-white/20 text-white text-sm px-3 py-1 rounded-full">{{ $place->placeType->name }}</span>
            @endif
            <h1 class="text-4xl font-bold text-white mt-2">{{ $place->name }}</h1>
            <p class="text-white/80">📍 {{ $place->address }}</p>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Hlavní obsah -->
        <div class="lg:col-span-2">
            @if($place->description)
            <div class="prose max-w-none mb-8">
                <h2 class="text-2xl font-bold mb-3">O místě</h2>
                <p class="text-gray-600 leading-relaxed">{{ $place->description }}</p>
            </div>
            @endif

            <!-- Program dle stage -->
            @foreach($place->stages as $stage)
            @if($stage->programSlots->count() > 0)
            <div class="mb-8">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-rose-500 rounded-full inline-block"></span>
                    {{ $stage->name }}
                    @if($stage->capacity)
                    <span class="text-sm font-normal text-gray-400">(kapacita: {{ $stage->capacity }})</span>
                    @endif
                </h3>
                <div class="space-y-3">
                    @foreach($stage->programSlots->where('status', 'published')->sortBy('starts_at') as $slot)
                    <div class="flex items-start gap-4 bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="text-center min-w-16">
                            <div class="text-rose-600 font-bold text-lg">{{ $slot->starts_at->format('H:i') }}</div>
                            <div class="text-gray-400 text-xs">– {{ $slot->ends_at->format('H:i') }}</div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <h4 class="font-semibold">{{ $slot->title }}</h4>
                                @if($slot->activityCategory)
                                <span class="text-xs px-2 py-0.5 rounded-full ml-2 flex-shrink-0" style="background-color: {{ $slot->activityCategory->color }}22; color: {{ $slot->activityCategory->color }}">
                                    {{ $slot->activityCategory->name }}
                                </span>
                                @endif
                            </div>
                            @if($slot->performer)
                            <p class="text-gray-500 text-sm">🎤 {{ $slot->performer }}</p>
                            @endif
                            @if($slot->description)
                            <p class="text-gray-400 text-sm mt-1">{{ $slot->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Info karta -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-lg mb-4">Informace</h3>
                <ul class="space-y-3 text-sm">
                    @if($place->program_from)
                    <li class="flex gap-2">
                        <span class="text-rose-500">🕐</span>
                        <span>{{ $place->program_from->format('d.m. H:i') }} – {{ $place->program_to?->format('d.m. H:i') }}</span>
                    </li>
                    @endif
                    @if($place->website)
                    <li class="flex gap-2">
                        <span>🌐</span>
                        <a href="{{ $place->website }}" target="_blank" class="text-rose-600 hover:underline">Web</a>
                    </li>
                    @endif
                    @if($place->facebook)
                    <li class="flex gap-2">
                        <span>📘</span>
                        <a href="{{ $place->facebook }}" target="_blank" class="text-rose-600 hover:underline">Facebook</a>
                    </li>
                    @endif
                    @if($place->instagram)
                    <li class="flex gap-2">
                        <span>📷</span>
                        <a href="{{ $place->instagram }}" target="_blank" class="text-rose-600 hover:underline">Instagram</a>
                    </li>
                    @endif
                    @if($place->organizer)
                    <li class="flex gap-2">
                        <span>👤</span>
                        <span>{{ $place->organizer->name }}</span>
                    </li>
                    @endif
                    @if($place->event)
                    <li class="flex gap-2">
                        <span>🎪</span>
                        <span>{{ $place->event->getTypeLabel() }}</span>
                    </li>
                    @endif
                </ul>
            </div>

            <!-- Dostupnost -->
            @if($place->accessibilityOptions->count() > 0)
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-lg mb-4">Dostupnost</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($place->accessibilityOptions as $acc)
                    <span class="bg-green-50 text-green-700 text-sm px-3 py-1 rounded-full">{{ $acc->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Mapa -->
            @if($place->lat && $place->lng)
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div id="detail-map" class="h-48"></div>
                <div class="p-4 text-sm text-gray-500">{{ $place->address }}</div>
            </div>
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                const dmap = L.map('detail-map').setView([{{ $place->lat }}, {{ $place->lng }}], 16);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(dmap);
                L.marker([{{ $place->lat }}, {{ $place->lng }}]).addTo(dmap)
                    .bindPopup('{{ $place->name }}').openPopup();
            </script>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('places.index') }}" class="text-rose-600 hover:underline">← Zpět na všechna místa</a>
    </div>
</div>
@endsection
