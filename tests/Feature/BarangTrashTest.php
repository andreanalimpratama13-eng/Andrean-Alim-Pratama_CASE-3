<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarangTrashTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleted_barang_appears_in_trash_and_can_be_restored(): void
    {
        $this->actingAs(User::factory()->create());
        $barang = Barang::create([
            'nama_barang' => 'Keyboard',
            'kode_barang' => 'BRG-001',
            'jumlah' => 5,
            'harga' => 150000,
        ]);

        $this->delete(route('barangs.destroy', $barang))
            ->assertRedirect(route('barangs.index'));

        $this->assertSoftDeleted($barang);
        $this->assertDatabaseMissing('barangs', [
            'id' => $barang->id,
            'deleted_at' => null,
        ]);

        $this->get(route('barangs.trash'))
            ->assertOk()
            ->assertSee('Keyboard')
            ->assertSee('Hapus permanen');

        $this->post(route('barangs.restore', $barang))
            ->assertRedirect(route('barangs.trash'));

        $this->assertNotSoftDeleted($barang);
        $this->get(route('barangs.index'))
            ->assertOk()
            ->assertSee('Keyboard');
    }

    public function test_barang_in_trash_can_be_permanently_deleted(): void
    {
        $this->actingAs(User::factory()->create());
        $barang = Barang::create([
            'nama_barang' => 'Mouse',
            'kode_barang' => 'BRG-002',
            'jumlah' => 3,
            'harga' => 50000,
        ]);
        $barang->delete();

        $this->delete(route('barangs.force-delete', $barang))
            ->assertRedirect(route('barangs.trash'))
            ->assertSessionHas('success', 'Barang berhasil dihapus permanen.');

        $this->assertDatabaseMissing('barangs', ['id' => $barang->id]);
        $this->assertDatabaseCount('barangs', 0);
    }
}
