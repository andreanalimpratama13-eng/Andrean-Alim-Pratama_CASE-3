<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    public const ACTIVE_CACHE_KEY = 'barangs.active';

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'jumlah',
        'harga',
    ];
}