<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f8fafc">
    <title>@yield('title', 'Beranda') - Stok Barang di Gudang</title>
    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen text-slate-900 antialiased @yield('body-class', 'bg-slate-50')">
    <header x-data="{ menuOpen: false }" class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('barangs.index') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/owl-logo.svg') }}" alt="" aria-hidden="true" width="40" height="40" class="size-10 rounded-xl bg-amber-50 p-1 shadow-lg shadow-amber-900/10">
                <span>
                    <span class="block text-sm font-bold tracking-tight text-slate-900 sm:text-base">Stok Barang di Gudang</span>
                    <span class="hidden text-xs text-slate-500 sm:block">Manajemen barang</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 md:flex" aria-label="Navigasi utama">
                @auth
                    <a href="{{ route('barangs.index') }}" class="{{ request()->routeIs('barangs.index') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">Barang</a>
                    <a href="{{ route('barangs.trash') }}" class="{{ request()->routeIs('barangs.trash') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">Sampah</a>
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-lg px-3 py-2 text-sm font-medium transition">Dashboard</a>
                    <span class="mx-2 h-6 w-px bg-slate-200"></span>
                    <span class="mr-2 text-sm text-slate-600">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <flux:button type="submit" variant="ghost" size="sm">Keluar</flux:button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Masuk</a>
                    <flux:button href="{{ route('register') }}" variant="primary" size="sm">Buat akun</flux:button>
                @endauth
            </nav>

            <button type="button"
                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 md:hidden"
                    aria-controls="mobile-navigation"
                    :aria-expanded="menuOpen.toString()"
                    @click="menuOpen = ! menuOpen">
                <span x-text="menuOpen ? 'Tutup' : 'Menu'"></span>
            </button>
        </div>

        <nav id="mobile-navigation" x-show="menuOpen" x-transition x-cloak class="border-t border-slate-200 bg-white px-4 py-3 md:hidden" aria-label="Navigasi seluler">
            @auth
                <div class="mb-3 px-3 text-sm text-slate-500">{{ auth()->user()->name }}</div>
                <a href="{{ route('barangs.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Barang</a>
                <a href="{{ route('barangs.trash') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Sampah</a>
                <a href="{{ url('/dashboard') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2 border-t border-slate-100 pt-2">
                    @csrf
                    <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-rose-600 hover:bg-rose-50">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100">Masuk</a>
                <a href="{{ route('register') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-indigo-700 hover:bg-indigo-50">Buat akun</a>
            @endauth
        </nav>
    </header>

    @if (session('success'))
        <div x-data="autoDismiss"
             x-show="visible"
             x-transition
             role="status"
             class="mx-auto mt-5 flex max-w-7xl items-center justify-between gap-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 sm:mx-6 lg:mx-auto">
            <span>{{ session('success') }}</span>
            <button type="button" class="rounded p-1 text-emerald-700 hover:bg-emerald-100" aria-label="Tutup notifikasi" @click="visible = false">Tutup</button>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="mx-auto max-w-7xl px-4 py-8 text-center text-xs text-slate-400 sm:px-6 lg:px-8">
        Stok Barang di Gudang &middot; Manajemen barang
    </footer>

    @fluxScripts
    @livewireScripts
</body>
</html>
