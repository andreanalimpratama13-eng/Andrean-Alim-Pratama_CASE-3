@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-600 p-7 text-white shadow-xl shadow-indigo-200 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-200">Dashboard</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Halo, {{ auth()->user()->name }}.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-indigo-100 sm:text-base">Selamat datang di Stokku. Kelola data barang dan pantau jumlah stok dengan mudah.</p>
            <flux:button href="{{ route('barangs.index') }}" variant="outline" class="mt-6">Buka inventaris</flux:button>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <a href="{{ route('barangs.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">
                <p class="text-sm font-semibold text-indigo-600">INVENTARIS</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900">Kelola barang</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Tambah, perbarui, dan lihat informasi barang yang aktif.</p>
            </a>
            <a href="{{ route('barangs.trash') }}" class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-200 hover:shadow-md">
                <p class="text-sm font-semibold text-rose-600">PEMULIHAN</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900">Sampah barang</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Lihat barang yang dihapus dan pulihkan jika masih diperlukan.</p>
            </a>
        </div>
    </div>
@endsection
