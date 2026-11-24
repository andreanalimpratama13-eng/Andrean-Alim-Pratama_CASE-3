<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barangs = [
            [
                'kode_barang' => 'BRG-001',
                'nama_barang' => 'Kertas A4',
                'jumlah' => 25,
                'harga' => 58000,
            ],
            [
                'kode_barang' => 'BRG-002',
                'nama_barang' => 'Pulpen Biru',
                'jumlah' => 120,
                'harga' => 3500,
            ],
            [
                'kode_barang' => 'BRG-003',
                'nama_barang' => 'Buku Catatan',
                'jumlah' => 40,
                'harga' => 12000,
            ],
        ];

        foreach ($barangs as $attributes) {
            $barang = Barang::withTrashed()->updateOrCreate(
                ['kode_barang' => $attributes['kode_barang']],
                $attributes,
            );

            if ($barang->trashed()) {
                $barang->restore();
            }
        }

        Cache::forget(Barang::ACTIVE_CACHE_KEY);
    }
}
