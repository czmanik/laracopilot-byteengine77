@extends('layouts.app')
@section('title', 'Program – Žižkovská noc & Mezidvorky 2026')

@section('content')
<div class="bg-gradient-to-r from-rose-700 to-rose-500 text-white py-12">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Program</h1>
        <p class="text-white/80">Kompletní přehled všech vystoupení a aktivit</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-10">
    <form method="GET" action="{{ route('program.index') }}" class="flex flex-wrap gap-3 mb-8">
        <select name="category" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400">
            <option value="">Všechny typy</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="place" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400">
            <option value="">Všechna místa</option>
            @foreach($places as $id => $name)
            <option value="{{ $id }}" {{ request('place') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-rose-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-rose-700 transition">Filtrovat</button>
        @if(request()->hasAny(['category', 'place']))
        <a href="{{ route('program.index') }}" class="border border-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Zrušit filtry</a>
        @endif
    </form>

    @if($slots->count() > 0)
    <div class="space-y-4">
        @php $currentDay = null; @endphp
        @foreach($slots as $slot)
            @if($currentDay !== $slot->starts_at->format('Y-m-d'))
                @php $currentDay = $slot->starts_at->format('Y-m-d'); @endphp
                <div class="mt-8 mb-4">
                    <h2 class="text-xl font-bold text-gray-700 border-b border-gray-200 pb-2">
                        {{ $slot->starts_at->translatedFormat('l, j. F Y') }}
                    </h2>
                </div>
            @endif
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="text-center sm:min-w-20">
                        <div class="text-rose-600 font-bold text-xl">{{ $slot->starts_at->format('H:i') }}</div>
                        <div class="text-gray-400 text-sm">{{ $slot->ends_at->format('H:i') }}</div>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="font-bold text-lg">{{ $slot->title }}</h3>
                            @if($slot->activityCategory)
                            <span class="text-xs px-2 py-0.5 rounded-full" style="background-color: {{ $slot->activityCategory->color }}22; color: {{ $slot->activityCategory->color }}">{{ $slot->activityCategory->name }}</span>
                            @endif
                        </div>
                        @if($slot->performer)
                        <p class="text-gray-500 text-sm">🎤 {{ $slot->performer }}</p>
                        @endif
                    </div>
                    <div class="text-right flex-shrink-0">
                        <a href="{{ route('places.show', $slot->place->slug) }}" class="text-rose-600 text-sm font-medium hover:underline">{{ $slot->place->name }}</a>
                        <div class="text-gray-400 text-xs">{{ $slot->stage->name }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-8">{{ $slots->links() }}</div>
    @else
    <div class="text-center py-16 text-gray-400">
        <div class="text-6xl mb-4">🎵</div>
        <p class="text-xl">Žádné programové položky neodpovídají filtru.</p>
        <a href="{{ route('program.index') }}" class="mt-4 inline-block text-rose-600 hover:underline">Zobrazit vše</a>
    </div>
    @endif
</div>
@endsection
