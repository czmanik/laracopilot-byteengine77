@extends('layouts.app')
@section('title', 'Místa – Žižkovská noc & Mezidvorky 2026')

@section('content')
<div class="bg-gradient-to-r from-rose-700 to-rose-500 text-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Místa</h1>
        <p class="text-white/80">Všechna zúčastněná místa a prostory</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('places.index') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('type') ? 'bg-rose-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-rose-400' }}">Vše</a>
        @foreach($placeTypes as $type)
        <a href="{{ route('places.index', ['type' => $type->id]) }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('type') == $type->id ? 'bg-rose-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-rose-400' }}">{{ $type->name }}</a>
        @endforeach
    </div>

    @if($places->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($places as $place)
        <a href="{{ route('places.show', $place->slug) }}" class="group bg-white rounded-2xl shadow hover:shadow-lg transition-all duration-300 overflow-hidden">
            <div class="h-48 bg-gradient-to-br from-rose-400 to-orange-400 relative overflow-hidden">
                @if($place->cover_image)
                <img src="{{ asset('storage/' . $place->cover_image) }}" alt="{{ $place->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full flex items-center justify-center text-6xl opacity-40">🏠</div>
                @endif
                @if($place->placeType)
                <span class="absolute top-3 left-3 bg-white/90 text-rose-700 text-xs font-semibold px-2 py-1 rounded-full">{{ $place->placeType->name }}</span>
                @endif
            </div>
            <div class="p-5">
                <h3 class="font-bold text-lg mb-1 group-hover:text-rose-600 transition-colors">{{ $place->name }}</h3>
                <p class="text-gray-500 text-sm mb-3">📍 {{ $place->address }}</p>
                @if($place->description)
                <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($place->description, 100) }}</p>
                @endif
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex gap-1 flex-wrap">
                        @foreach($place->accessibilityOptions->take(2) as $acc)
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded">{{ $acc->name }}</span>
                        @endforeach
                    </div>
                    <span class="text-rose-600 text-sm font-medium">Detail →</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $places->links() }}</div>
    @else
    <div class="text-center py-16 text-gray-400">
        <div class="text-6xl mb-4">🗺️</div>
        <p class="text-xl">Zatím nejsou přidána žádná místa.</p>
    </div>
    @endif
</div>
@endsection
