@extends('layouts.app')
@section('title', 'Kontakt – Žižkovská noc & Mezidvorky 2026')

@section('content')
<div class="bg-gradient-to-r from-rose-700 to-rose-500 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">Kontakt</h1>
        <p class="text-xl text-white/85">Máte otázku? Napište nám</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
            <h2 class="text-2xl font-bold mb-6">Napište nám</h2>
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jméno *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-400 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-400 @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zpráva *</label>
                    <textarea name="message" rows="5" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-400 @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="bg-rose-600 text-white font-semibold px-8 py-3 rounded-lg hover:bg-rose-700 transition w-full">Odeslat zprávu</button>
            </form>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-6">Kde nás najdete</h2>
            <div class="space-y-6">
                <div class="flex gap-4"><div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">📧</div><div><div class="font-semibold">E-mail</div><a href="mailto:info@zizkovska-noc.cz" class="text-rose-600 hover:underline">info@zizkovska-noc.cz</a></div></div>
                <div class="flex gap-4"><div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">📍</div><div><div class="font-semibold">Místo konání</div><div class="text-gray-600">Praha 3 – Žižkov</div></div></div>
                <div class="flex gap-4"><div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">📱</div><div><div class="font-semibold">Sociální sítě</div><div class="flex gap-3 mt-1"><a href="#" class="text-rose-600 hover:underline">Facebook</a><a href="#" class="text-rose-600 hover:underline">Instagram</a></div></div></div>
            </div>
            <div class="mt-8 bg-rose-50 rounded-2xl p-6">
                <h3 class="font-bold mb-2">Chcete se zapojit?</h3>
                <p class="text-gray-600 text-sm">Provozujete prostor na Žižkově a chcete se přidat? Kontaktujte nás a my vás zařadíme do systému.</p>
            </div>
        </div>
    </div>
</div>
@endsection
