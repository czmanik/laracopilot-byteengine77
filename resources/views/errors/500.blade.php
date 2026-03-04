@extends('layouts.app')
@section('title', '500 – Chyba serveru')
@section('content')
<div class="min-h-96 flex items-center justify-center py-24">
    <div class="text-center px-4">
        <div class="text-9xl font-black text-rose-200 mb-4">500</div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Chyba serveru</h1>
        <p class="text-gray-500 mb-8">Něco se pokazilo. Zkuste to prosím znovu.</p>
        <a href="{{ route('home') }}" class="bg-rose-600 text-white font-semibold px-8 py-3 rounded-full hover:bg-rose-700 transition">← Zpět na úvod</a>
    </div>
</div>
@endsection
