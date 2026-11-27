# Sistem Informasi Perpustakaan Sederhana

## Deskripsi Aplikasi
**Sistem Informasi Perpustakaan Sederhana** merupakan aplikasi web berbasis Laravel yang dikembangkan untuk membantu pengelolaan data buku, kategori, anggota, pengguna, serta transaksi peminjaman dan pengembalian buku secara terstruktur dan efisien.

Proyek ini dibuat untuk memenuhi tugas Final Project Ujian Akhir Semester (UAS) mata kuliah **Pemrograman Web Framework** — Program Studi S1 Sistem Informasi, Fakultas Ilmu Komputer, Universitas Singaperbangsa Karawang.

## Fitur Aplikasi
- **Login, Logout & Reset Password:** Autentikasi pengguna untuk masuk, keluar, dan mengatur ulang kata sandi sistem.
- **Dashboard:** Ringkasan statistik dan informasi utama operasional perpustakaan.
- **Hak Akses (Admin & Petugas):** Pengelolaan akun pengguna (*User Management*) dan pembatasan hak akses berbasis peran (*Role-Based Access Control*) di sisi server, di mana **Petugas** tidak dapat mengakses menu maupun URL pengelolaan user.
- **Pengelolaan Kategori:** Tambah, ubah, cari, dan hapus data kategori buku.
- **Pengelolaan Buku:** CRUD data buku, unggah gambar *cover* buku (JPG/PNG/WEBP maksimal 2 MB), pencarian koleksi, pengelolaan stok otomatis, serta halaman **Detail Buku**.
- **Pengelolaan Anggota:** Tambah, ubah, cari, dan hapus data anggota perpustakaan dengan pembuatan kode anggota otomatis (`MBR-001`, dst.).
- **Pengelolaan Peminjaman & Pengembalian:**
  - Pencatatan peminjaman beberapa buku sekaligus dalam satu transaksi.
  - **Validasi Tanggal & Duplikasi:** Tanggal peminjaman dikunci otomatis pada hari berjalan (`today`), batas waktu pengembalian otomatis 7 hari, serta mencegah pemilihan judul buku yang sama lebih dari satu kali dalam satu transaksi.
  - **Validasi & Pembaruan Stok Otomatis:** Memastikan stok mencukupi saat peminjaman, lalu memperbarui status menjadi *Returned*, mencatat tanggal kembali (`return_date`), dan mengembalikan stok buku secara otomatis saat proses pengembalian.

## Teknologi yang Digunakan
- PHP 8.3
- Laravel 13
- Laravel Breeze (Autentikasi)
- MySQL / MariaDB
- Composer 2.10 & Node.js / NPM (Vite)
- HTML5, CSS3, Tailwind CSS, Alpine.js, Blade Template
- Git & GitHub

## Persyaratan Sistem
Sebelum menjalankan aplikasi ini secara lokal, pastikan perangkat telah terpasang:
- PHP >= 8.3
- Composer >= 2.10
- Node.js & NPM
- MySQL / MariaDB (XAMPP, Laragon, atau sejenisnya)
- Git
- Web Browser

## Instalasi dan Konfigurasi
1. Buat database kosong pada MySQL/MariaDB dengan nama `db_sip_sederhana`
2. Clone repository proyek dan masuk ke direktori proyek:
   ```bash
   git clone https://github.com/raarchive-tech/sistem-informasi-perpustakaan-sederhana.git
   cd sistem-informasi-perpustakaan-sederhana

3. Instal dependensi PHP dan JavaScript, lalu kompilasi aset frontend:
   composer install
   npm install
   npm run build
   
4. Salin file konfigurasi .env dan generate application key:
   cp .env.example .env
   php artisan key:generate

5. Jalankan migrasi database beserta data awal (seeder), buat symbolic link penyimpanan cover buku, lalu jalankan server lokal:
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
   Buka aplikasi melalui browser pada alamat http://127.0.0.1:8000.

## Akun Demo
Berikut adalah akun khusus demonstrasi yang dapat digunakan untuk pengujian aplikasi:
Admin: admin@gmail.com — Password: password123
Petugas: petugas1@gmail.com — Password: password123

## Screenshot Aplikasi
1. [Halaman Login](docs/screenshots/login.png)
2. [Halaman Dashboard](docs/screenshots/dashboard.png)
3. [Halaman Kategori](docs/screenshots/kategori.png)
4. [Halaman Buku & Detail Cover](docs/screenshots/buku.png)
5. [Halaman Anggota](docs/screenshots/anggota.png)
6. [Halaman Peminjaman & Pengembalian](docs/screenshots/peminjaman.png)
7. [Halaman User Management (Admin)](docs/screenshots/users.png)

# Anggota Kelompok (Kelompok 9 — Kelas 5B Sistem Informasi)
1. Agatha Kristia Putri (NPM 2410631250036)
2. Andhika Muldani Gathfan Firdaus (NPM 2410631250039)
3. Rahma Nur Khotimah (NPM 2410631250029)
