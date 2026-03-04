<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Žižkovská noc & Mezidvorky 2026')</title>
    <meta name="description" content="@yield('description', 'Žižkovská noc a Žižkovské mezidvorky 2026 – festival v srdci Žižkova.')">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link { @apply text-white/80 hover:text-white transition-colors duration-200; }
        .nav-link.active { @apply text-white font-semibold; }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900">

<!-- Navigace -->
<nav class="bg-gradient-to-r from-rose-700 to-rose-500 shadow-lg sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-white font-bold text-xl tracking-tight">🌃 Žižkov 2026</span>
            </a>

            <!-- Desktop menu -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Úvod</a>
                <a href="{{ route('places.index') }}" class="nav-link {{ request()->routeIs('places.*') ? 'active' : '' }}">Místa</a>
                <a href="{{ route('program.index') }}" class="nav-link {{ request()->routeIs('program.*') ? 'active' : '' }}">Program</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">O nás</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontakt</a>
                <a href="/admin" class="ml-4 bg-white text-rose-600 font-semibold px-4 py-1.5 rounded-full text-sm hover:bg-rose-50 transition">Admin</a>
            </div>

            <!-- Mobile burger -->
            <button id="mobile-toggle" class="md:hidden text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="nav-link">Úvod</a>
                <a href="{{ route('places.index') }}" class="nav-link">Místa</a>
                <a href="{{ route('program.index') }}" class="nav-link">Program</a>
                <a href="{{ route('about') }}" class="nav-link">O nás</a>
                <a href="{{ route('contact') }}" class="nav-link">Kontakt</a>
                <a href="/admin" class="text-white font-semibold">→ Admin</a>
            </div>
        </div>
    </div>
</nav>

<!-- Flash zprávy -->
@if(session('success'))
<div class="bg-green-500 text-white text-center py-3 px-4">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="bg-red-500 text-white text-center py-3 px-4">
    {{ session('error') }}
</div>
@endif

<!-- Obsah -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-white mt-16">
    <div class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="md:col-span-2">
            <h3 class="text-xl font-bold mb-3">🌃 Žižkov 2026</h3>
            <p class="text-gray-400 text-sm leading-relaxed">Žižkovská noc a Žižkovské mezidvorky jsou každoroční kulturní festivaly v srdci pražského Žižkova. Otevíráme brány klubů, kaváren, restaurací a dvorů pro všechny.</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3 text-gray-200">Navigace</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('places.index') }}" class="hover:text-white transition">Místa</a></li>
                <li><a href="{{ route('program.index') }}" class="hover:text-white transition">Program</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-white transition">O nás</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-white transition">Kontakt</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3 text-gray-200">Kontakt</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li>📧 info@zizkovska-noc.cz</li>
                <li>📍 Praha 3 – Žižkov</li>
                <li class="pt-2">
                    <a href="https://www.facebook.com" target="_blank" class="hover:text-white transition">Facebook</a>
                    &nbsp;·&nbsp;
                    <a href="https://www.instagram.com" target="_blank" class="hover:text-white transition">Instagram</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-800 py-6 text-center text-sm text-gray-500">
        <p>© {{ date('Y') }} Žižkovská noc & Žižkovské mezidvorky. Všechna práva vyhrazena.</p>
        <p class="mt-1">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="hover:text-gray-300">LaraCopilot</a></p>
    </div>
</footer>

<script>
    document.getElementById('mobile-toggle').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@stack('scripts')
</body>
</html>
