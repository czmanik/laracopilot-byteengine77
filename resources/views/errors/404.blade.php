@extends('layouts.app')
@section('title', '404 – Stránka nenalezena')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center px-4">
        <div class="text-9xl font-black text-rose-200 mb-4">404</div>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Stránka nenalezena</h1>
        <p class="text-gray-500 mb-8">Tato stránka neexistuje nebo byla přesunuta.</p>
        <a href="{{ route('home') }}" class="bg-rose-600 text-white font-semibold px-8 py-3 rounded-full hover:bg-rose-700 transition">← Zpět na úvod</a>
    </div>
</div>
@endsection
