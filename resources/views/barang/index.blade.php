@extends('layouts.app')

@section('title', 'Data Barang')
@section('body-class', 'bg-[#EFF6FF]')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-indigo-600">INVENTARIS</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Data barang</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Pantau stok, harga, dan informasi barang dalam satu tempat.</p>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <flux:button href="{{ route('barangs.trash') }}" variant="outline">Lihat sampah</flux:button>
                <flux:button href="{{ route('barangs.create') }}" variant="primary">Tambah barang</flux:button>
            </div>
        </div>

        <livewire:barang-table />
    </div>
@endsection
