<div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Jenis barang aktif</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($totalBarang, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-500">Barang yang tercatat di inventaris</p>
        </div>
        <div class="rounded-2xl border border-indigo-100 bg-indigo-600 p-5 text-white shadow-sm shadow-indigo-100">
            <p class="text-sm font-medium text-indigo-100">Total stok</p>
            <p class="mt-2 text-3xl font-bold tracking-tight">{{ number_format($totalStok, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-indigo-100">Jumlah seluruh unit barang aktif</p>
        </div>
    </div>

    <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold tracking-tight text-slate-900">Daftar barang</h2>
                <p class="mt-1 text-sm text-slate-500">Cari dan kelola barang yang tersimpan.</p>
            </div>
            <div class="w-full sm:max-w-xs">
                <label for="barang-search" class="sr-only">Cari barang</label>
                <input id="barang-search"
                       type="search"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama atau kode barang..."
                       class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[760px] w-full divide-y divide-slate-100 text-left text-sm">
                <caption class="sr-only">Daftar barang aktif</caption>
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3">Barang</th>
                        <th scope="col" class="px-5 py-3">Kode</th>
                        <th scope="col" class="px-5 py-3">Stok</th>
                        <th scope="col" class="px-5 py-3">Harga satuan</th>
                        <th scope="col" class="px-5 py-3">Harga total</th>
                        <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($barangs as $barang)
                        <tr wire:key="barang-{{ $barang['id'] }}" class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4">
                                <span class="block font-semibold text-slate-900">{{ $barang['nama_barang'] }}</span>
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-slate-600">{{ $barang['kode_barang'] }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                                    {{ number_format($barang['jumlah'], 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 font-medium text-slate-700">Rp {{ number_format($barang['harga'], 0, ',', '.') }}</td>
                            <td class="px-5 py-4 font-medium text-slate-700">Rp {{ number_format($barang['harga'] * $barang['jumlah'], 0, ',', '.') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('barangs.edit', $barang['id']) }}" variant="outline" size="sm">Ubah</flux:button>
                                    <form action="{{ route('barangs.destroy', $barang['id']) }}"
                                          method="POST"
                                          x-data
                                          @submit="if (! window.confirm('Pindahkan barang ini ke sampah?')) $event.preventDefault()">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="danger" size="sm">Hapus</flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <p class="font-semibold text-slate-700">{{ $search ? 'Barang tidak ditemukan' : 'Belum ada barang' }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $search ? 'Coba kata kunci yang berbeda.' : 'Tambahkan barang pertama untuk mulai mengelola inventaris.' }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 bg-slate-50/70 px-5 py-3 text-xs text-slate-500">
            Menampilkan {{ count($barangs) }} dari {{ $totalBarang }} jenis barang
        </div>
    </section>
</div>
