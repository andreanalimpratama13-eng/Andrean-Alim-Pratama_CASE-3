# Stokku — Manajemen Barang

Aplikasi inventaris sederhana untuk mencatat stok barang.

## Fitur

- Login dan pendaftaran akun dengan autentikasi Laravel dan password hashing.
- CRUD barang dengan validasi dan fitur soft delete; barang yang dihapus dapat dipulihkan.
- Migrasi dan seeder untuk data awal barang.
- Antarmuka responsif menggunakan Tailwind CSS dan komponen Flux.
- Tabel inventaris menggunakan Livewire, pencarian interaktif, dan cache yang diperbarui setelah data berubah.
- Navigasi seluler dan notifikasi interaktif menggunakan Alpine.js.

## Menjalankan aplikasi

Siapkan database MySQL di `.env`, lalu jalankan dari PowerShell:

```powershell
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve --host=0.0.0.0 --port=8000
```

Buat akun melalui halaman **Daftar**, lalu masuk untuk mengelola barang. `php artisan migrate --seed` membuat struktur database dan mengisi contoh barang.

## Akses dari perangkat lain

Sebelum membuka aplikasi dari perangkat lain, jalankan `npm run build` dan pastikan server Laravel dijalankan dengan `--host=0.0.0.0`. Teruskan port `8000` melalui fitur port forwarding IDE atau jaringan lokal, kemudian buka alamat yang diberikan pada perangkat tujuan. CSS dan JavaScript hasil build disajikan dari aplikasi pada origin yang sama, sehingga tampilan Tailwind tetap termuat tanpa bergantung pada server HMR Vite lokal.

## Pengujian

```powershell
php artisan test
```
