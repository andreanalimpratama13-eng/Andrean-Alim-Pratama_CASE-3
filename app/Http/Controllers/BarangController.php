<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BarangController extends Controller
{
    // Menampilkan semua data barang
    public function index()
    {
        return view('barang.index');
    }

    // Menampilkan barang yang ada di sampah
    public function trash()
    {
        $barangs = Barang::onlyTrashed()->get();

        return view('barang.trash', compact('barangs'));
    }

    // Menampilkan form tambah barang
    public function create()
    {
        return view('barang.create');
    }

    // Menyimpan barang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        Barang::create($validated);
        $this->clearBarangCache();

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    // Menampilkan form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.edit', compact('barang'));
    }

    // Memperbarui data barang
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $barang->update($validated);
        $this->clearBarangCache();

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    // Memindahkan barang ke sampah
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $barang->delete();
        $this->clearBarangCache();

        return redirect()->route('barangs.index')
            ->with('success', 'Barang berhasil dipindahkan ke sampah!');
    }

    // Memulihkan barang dari sampah
    public function restore($id)
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);

        $barang->restore();
        $this->clearBarangCache();

        return redirect()->route('barangs.trash')
            ->with('success', 'Barang berhasil dipulihkan!');
    }

    // Menghapus barang dari database secara permanen
    public function forceDelete($id)
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);

        $barang->forceDelete();
        $this->clearBarangCache();

        return redirect()->route('barangs.trash')
            ->with('success', 'Barang berhasil dihapus permanen.');
    }

    private function clearBarangCache(): void
    {
        Cache::forget(Barang::ACTIVE_CACHE_KEY);
    }
}