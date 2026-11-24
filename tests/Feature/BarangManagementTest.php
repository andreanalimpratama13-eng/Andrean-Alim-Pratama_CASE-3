<?php

namespace Tests\Feature;

use App\Livewire\BarangTable;
use App\Models\Barang;
use App\Models\User;
use Database\Seeders\BarangSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class BarangManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_barang_can_be_created_and_updated(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('barangs.store'), $this->barangData('BRG-100', 'Keyboard'))
            ->assertRedirect(route('barangs.index'));

        $barang = Barang::where('kode_barang', 'BRG-100')->firstOrFail();

        $this->put(route('barangs.update', $barang), $this->barangData('BRG-100', 'Keyboard Mekanis', [
            'jumlah' => 8,
        ]))->assertRedirect(route('barangs.index'));

        $this->assertDatabaseHas('barangs', [
            'id' => $barang->id,
            'nama_barang' => 'Keyboard Mekanis',
            'jumlah' => 8,
        ]);
    }

    public function test_inventory_page_uses_the_login_background_color(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('barangs.index'))
            ->assertOk()
            ->assertSee('bg-[#EFF6FF]', false);
    }

    public function test_livewire_inventory_searches_and_refreshes_cached_data_after_create(): void
    {
        $this->actingAs(User::factory()->create());
        Cache::forget(Barang::ACTIVE_CACHE_KEY);

        Barang::create($this->barangData('BRG-101', 'Keyboard'));
        Barang::create($this->barangData('BRG-102', 'Mouse'));

        Livewire::test(BarangTable::class)
            ->assertSee('Keyboard')
            ->assertSee('Mouse')
            ->set('search', 'keyboard')
            ->assertSee('Keyboard')
            ->assertDontSee('Mouse');

        $cachedBarangs = Cache::get(Barang::ACTIVE_CACHE_KEY);
        $this->assertIsArray($cachedBarangs);
        $this->assertIsArray($cachedBarangs[0]);

        $this->post(route('barangs.store'), $this->barangData('BRG-103', 'Monitor'))
            ->assertRedirect(route('barangs.index'));

        Livewire::test(BarangTable::class)
            ->assertSee('Mouse')
            ->assertSee('Monitor');
    }

    public function test_inventory_shows_unit_price_and_total_price_for_stock_quantity(): void
    {
        Barang::create($this->barangData('BRG-104', 'Headset', [
            'jumlah' => 3,
            'harga' => 25000,
        ]));

        Livewire::test(BarangTable::class)
            ->assertSee('Harga satuan')
            ->assertSee('Harga total')
            ->assertSee('Rp 75.000');
    }

    public function test_barang_seeder_is_repeatable(): void
    {
        $this->seed(BarangSeeder::class);
        $this->seed(BarangSeeder::class);

        $this->assertDatabaseCount('barangs', 3);
    }

    public function test_barang_table_no_longer_has_a_satuan_column(): void
    {
        $this->assertFalse(Schema::hasColumn('barangs', 'satuan'));
    }

    private function barangData(string $kode, string $nama, array $overrides = []): array
    {
        return array_merge([
            'kode_barang' => $kode,
            'nama_barang' => $nama,
            'jumlah' => 5,
            'harga' => 150000,
        ], $overrides);
    }
}
