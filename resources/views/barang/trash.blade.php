@extends('layouts.app')

@section('title', 'Sampah Barang')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-rose-600">PEMULIHAN DATA</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Sampah barang</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Barang di sini belum terhapus permanen. Pulihkan kapan saja untuk mengembalikannya ke inventaris.</p>
            </div>
            <flux:button href="{{ route('barangs.index') }}" variant="outline">Kembali ke inventaris</flux:button>
        </div>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="font-semibold text-slate-900">Barang yang dihapus</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $barangs->count() }} barang berada di sampah</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-[760px] w-full divide-y divide-slate-100 text-left text-sm">
                    <caption class="sr-only">Barang yang dapat dipulihkan</caption>
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th scope="col" class="px-5 py-3">Barang</th>
                            <th scope="col" class="px-5 py-3">Kode</th>
                            <th scope="col" class="px-5 py-3">Stok</th>
                            <th scope="col" class="px-5 py-3">Harga satuan</th>
                            <th scope="col" class="px-5 py-3">Harga total</th>
                            <th scope="col" class="px-5 py-3">Dihapus</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($barangs as $barang)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-5 py-4">
                                    <span class="block font-semibold text-slate-900">{{ $barang->nama_barang }}</span>
                                </td>
                                <td class="px-5 py-4 font-mono text-xs text-slate-600">{{ $barang->kode_barang }}</td>
                                <td class="px-5 py-4 text-slate-700">{{ number_format($barang->jumlah, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 font-medium text-slate-700">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 font-medium text-slate-700">Rp {{ number_format($barang->harga * $barang->jumlah, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $barang->deleted_at->format('d M Y, H:i') }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-col items-end gap-2 sm:flex-row sm:justify-end">
                                    <form action="{{ route('barangs.restore', $barang) }}" method="POST">
                                        @csrf
                                        <flux:button type="submit" variant="primary" size="sm">Pulihkan</flux:button>
                                    </form>
                                    <form action="{{ route('barangs.force-delete', $barang) }}"
                                          method="POST"
                                          x-data
                                          @submit="if (! window.confirm('Hapus barang ini secara permanen? Data tidak dapat dipulihkan.')) $event.preventDefault()">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="danger" size="sm">Hapus permanen</flux:button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-14 text-center">
                                    <p class="font-semibold text-slate-700">Sampah masih kosong</p>
                                    <p class="mt-1 text-sm text-slate-500">Barang yang dihapus akan muncul di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
