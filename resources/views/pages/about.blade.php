@extends('layouts.app')
@section('title', 'O nás – Žižkovská noc & Mezidvorky 2026')

@section('content')
<div class="bg-gradient-to-r from-rose-700 to-rose-500 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">O projektu</h1>
        <p class="text-xl text-white/85">Kdo stojí za Žižkovskou nocí a Mezidvorky</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="space-y-6 text-gray-600 leading-relaxed">
        <h2 class="text-2xl font-bold text-gray-900">Co je Žižkovská noc?</h2>
        <p>Žižkovská noc je každoroční kulturní festival probíhající ve dvou dnech v pražském Žižkově. Otevírají se brány desítek klubů, barů, kaváren a galerií nabízejících bohatý program od živé hudby přes divadelní představení až po výstavy.</p>
        <p>Vstupné zahrnuje přístup do všech zúčastněných podniků. Tato unikátní koncepce přináší návštěvníkům možnost prozkoumat dění na Žižkově a podpořit místní kulturu.</p>

        <h2 class="text-2xl font-bold text-gray-900 mt-8">Co jsou Žižkovské mezidvorky?</h2>
        <p>Žižkovské mezidvorky jsou letní komunitní festival, který zpřístupňuje veřejnosti soukromé dvory, zahrady a skrytá místa Žižkova. Na rozdíl od Žižkovské noci je vstup zcela zdarma.</p>

        <h2 class="text-2xl font-bold text-gray-900 mt-8">Naše mise</h2>
        <p>Věříme, že kultura a komunita jdou ruku v ruce. Naším cílem je propojit místní podniky, umělce a obyvatele Žižkova.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
        <div class="bg-rose-50 rounded-2xl p-6 text-center"><div class="text-5xl mb-3">🎭</div><h3 class="font-bold text-xl mb-2">Kultura</h3><p class="text-gray-600 text-sm">Živá hudba, divadlo, výstavy a performance od místních umělců</p></div>
        <div class="bg-orange-50 rounded-2xl p-6 text-center"><div class="text-5xl mb-3">🏘️</div><h3 class="font-bold text-xl mb-2">Komunita</h3><p class="text-gray-600 text-sm">Propojujeme místní podniky, umělce a obyvatele Žižkova</p></div>
        <div class="bg-green-50 rounded-2xl p-6 text-center"><div class="text-5xl mb-3">🌱</div><h3 class="font-bold text-xl mb-2">Udržitelnost</h3><p class="text-gray-600 text-sm">Podporujeme lokální hospodářství a udržitelné projekty</p></div>
    </div>
</div>
@endsection
