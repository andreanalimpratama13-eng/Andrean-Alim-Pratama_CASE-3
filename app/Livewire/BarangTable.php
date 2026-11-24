<?php

namespace App\Livewire;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BarangTable extends Component
{
    public string $search = '';

    public function render(): View
    {
        $allBarangs = Cache::remember(
            Barang::ACTIVE_CACHE_KEY,
            now()->addMinutes(5),
            fn (): array => Barang::query()
                ->orderBy('nama_barang')
                ->get(['id', 'kode_barang', 'nama_barang', 'jumlah', 'harga'])
                ->map(fn (Barang $barang): array => [
                    'id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'jumlah' => $barang->jumlah,
                    'harga' => $barang->harga,
                ])
                ->all(),
        );

        $search = mb_strtolower(trim($this->search));
        $barangs = array_values(array_filter(
            $allBarangs,
            function (array $barang) use ($search): bool {
                if ($search === '') {
                    return true;
                }

                $searchable = mb_strtolower(
                    $barang['kode_barang'].' '.$barang['nama_barang'],
                );

                return str_contains($searchable, $search);
            },
        ));

        return view('livewire.barang-table', [
            'barangs' => $barangs,
            'totalBarang' => count($allBarangs),
            'totalStok' => array_sum(array_column($allBarangs, 'jumlah')),
        ]);
    }
}
