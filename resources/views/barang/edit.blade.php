@extends('layouts.app')

@section('title', 'Ubah Barang')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <a href="{{ route('barangs.index') }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-900">&larr; Kembali ke inventaris</a>
        <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
            <p class="text-sm font-semibold text-indigo-600">PERBARUI INVENTARIS</p>
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Ubah barang</h1>
            <p class="mt-2 text-sm text-slate-600">Perbarui informasi {{ $barang->nama_barang }}.</p>

            @if ($errors->any())
                <div role="alert" class="mt-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    Periksa kembali isian yang ditandai.
                </div>
            @endif

            <form action="{{ route('barangs.update', $barang) }}" method="POST" class="mt-7 space-y-5"
                  x-data="{
                      jumlah: @js((int) old('jumlah', $barang->jumlah)),
                      harga: @js((float) old('harga', $barang->harga)),
                      formatRupiah(value) {
                          return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(value || 0);
                      }
                  }">
                @csrf
                @method('PUT')
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="kode_barang" class="mb-1.5 block text-sm font-medium text-slate-700">Kode barang</label>
                        <input id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required maxlength="255" autocomplete="off"
                               class="h-11 w-full rounded-lg border border-slate-300 px-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('kode_barang') border-rose-400 @enderror">
                        @error('kode_barang') <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="nama_barang" class="mb-1.5 block text-sm font-medium text-slate-700">Nama barang</label>
                        <input id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required maxlength="255"
                               class="h-11 w-full rounded-lg border border-slate-300 px-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('nama_barang') border-rose-400 @enderror">
                        @error('nama_barang') <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="jumlah" class="mb-1.5 block text-sm font-medium text-slate-700">Jumlah stok</label>
                        <input id="jumlah" type="number" name="jumlah" value="{{ old('jumlah', $barang->jumlah) }}" required min="0" step="1" x-model.number="jumlah"
                               class="h-11 w-full rounded-lg border border-slate-300 px-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('jumlah') border-rose-400 @enderror">
                        @error('jumlah') <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="harga" class="mb-1.5 block text-sm font-medium text-slate-700">Harga satuan (Rp)</label>
                        <input id="harga" type="number" name="harga" value="{{ old('harga', $barang->harga) }}" required min="0" step="0.01" x-model.number="harga"
                               class="h-11 w-full rounded-lg border border-slate-300 px-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('harga') border-rose-400 @enderror">
                        @error('harga') <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3" aria-live="polite">
                    <p class="text-sm font-medium text-indigo-900">Harga total sesuai jumlah</p>
                    <p class="mt-1 text-lg font-bold text-indigo-700" x-text="'Rp ' + formatRupiah(jumlah * harga)"></p>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <flux:button href="{{ route('barangs.index') }}" variant="outline">Batal</flux:button>
                    <flux:button type="submit" variant="primary">Simpan perubahan</flux:button>
                </div>
            </form>
        </div>
    </div>
@endsection
