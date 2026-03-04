@extends('layouts.app')
@section('title', 'Žižkovská noc & Mezidvorky 2026 – Festival na Žižkově')

@section('content')
<!-- Hero -->
<section class="relative bg-gradient-to-br from-rose-800 via-rose-600 to-orange-500 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"white\" fill-opacity=\"0.4\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="relative max-w-6xl mx-auto px-4 py-24 text-center">
        @if($activeEvent)
        <span class="inline-block bg-white/20 backdrop-blur text-white text-sm font-medium px-4 py-1 rounded-full mb-6">
            {{ $activeEvent->getTypeLabel() }} · {{ $activeEvent->date_from->format('d.m.') }}–{{ $activeEvent->date_to->format('d.m.Y') }}
        </span>
        @endif
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
            Žižkov<br><span class="text-orange-200">ožívá</span>
        </h1>
        <p class="text-xl md:text-2xl text-white/85 max-w-2xl mx-auto mb-10">
            Dva dny, desítky míst, stovky akcí. Žižkovská noc a Mezidvorky otevírají brány klubů, kaváren, dvorů a galerií.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('program.index') }}" class="bg-white text-rose-700 font-bold px-8 py-4 rounded-full text-lg hover:bg-orange-50 transition shadow-lg">
                📅 Zobrazit program
            </a>
            <a href="{{ route('places.index') }}" class="border-2 border-white text-white font-bold px-8 py-4 rounded-full text-lg hover:bg-white/10 transition">
                🗺️ Mapa míst
            </a>
        </div>
    </div>
</section>

<!-- Mapa -->
@if($places->count() > 0)
<section class="max-w-6xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold mb-2">Místa na mapě</h2>
        <p class="text-gray-500">Klikněte na bod pro zobrazení detailu místa</p>
    </div>
    <div id="map" class="w-full h-96 rounded-2xl shadow-lg border border-gray-200"></div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([50.0867, 14.4622], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        const places = @json($places);
        places.forEach(p => {
            if (p.lat && p.lng) {
                L.marker([p.lat, p.lng])
                    .addTo(map)
                    .bindPopup(`<strong>${p.name}</strong><br>${p.address}<br><a href="/mista/${p.slug}" style="color:#e11d48">Detail →</a>`);
            }
        });
    </script>
</section>
@endif

<!-- Nadcházející program -->
@if($upcomingSlots->count() > 0)
<section class="bg-gray-100 py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Nejbližší program</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($upcomingSlots as $slot)
            <div class="bg-white rounded-xl shadow hover:shadow-md transition-shadow p-5">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-xs font-medium bg-rose-100 text-rose-700 px-2 py-1 rounded-full">
                        {{ $slot->activityCategory?->name ?? 'Program' }}
                    </span>
                    <span class="text-xs text-gray-400">{{ $slot->starts_at->format('d.m. H:i') }}</span>
                </div>
                <h3 class="font-bold text-lg mb-1">{{ $slot->title }}</h3>
                @if($slot->performer)
                <p class="text-gray-500 text-sm mb-2">🎤 {{ $slot->performer }}</p>
                @endif
                <p class="text-sm text-gray-400">📍 {{ $slot->place->name }} · {{ $slot->stage->name }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('program.index') }}" class="bg-rose-600 text-white font-semibold px-8 py-3 rounded-full hover:bg-rose-700 transition">Celý program →</a>
        </div>
    </div>
</section>
@endif

<!-- O akcích -->
<section class="max-w-6xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div>
            <span class="text-rose-600 font-semibold text-sm">O festivalu</span>
            <h2 class="text-3xl font-bold mt-2 mb-4">Dvě akce, jeden Žižkov</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">Žižkovská noc každoročně otvírá dveře klubů a barů pro hudební milovníky. Vstupné zahrnuje přístup do všech zúčastněných podniků a večer plný živé hudby, DJs a umění.</p>
            <p class="text-gray-600 leading-relaxed">Žižkovské mezidvorky jsou pak letní slavnost zadarmo – otevíráme soukromé dvory, komunitní zahrady a skrytá zákoutí Žižkova pro setkávání, divadlo, hudbu i gastro.</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-rose-50 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">🌃</div>
                <h3 class="font-bold text-rose-800">Žižkovská noc</h3>
                <p class="text-sm text-rose-600 mt-1">Kluby · Hudba · Vstupné</p>
            </div>
            <div class="bg-orange-50 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">🏡</div>
                <h3 class="font-bold text-orange-800">Mezidvorky</h3>
                <p class="text-sm text-orange-600 mt-1">Dvory · Kultura · Zdarma</p>
            </div>
            <div class="bg-purple-50 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">🎭</div>
                <h3 class="font-bold text-purple-800">Divadlo & Umění</h3>
                <p class="text-sm text-purple-600 mt-1">Performance · Výstavy</p>
            </div>
            <div class="bg-green-50 rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">🍽️</div>
                <h3 class="font-bold text-green-800">Gastro</h3>
                <p class="text-sm text-green-600 mt-1">Jídlo · Pití · Trhy</p>
            </div>
        </div>
    </div>
</section>
@endsection
