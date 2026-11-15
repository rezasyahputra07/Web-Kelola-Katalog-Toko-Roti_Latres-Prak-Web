# Website Katalog Kue - Toko Roti

Aplikasi web sederhana berbasis **PHP**, **MySQL**, **HTML** dan **Bootstrap** untuk mengelola katalog kue oleh admin toko (Latihan Responsi Praktikum Web).

## Fitur Utama
* **Autentikasi & Session**: Register (`password_hash`), Login (`password_verify`), proteksi halaman dengan `$_SESSION`, dan Logout.
* **Dashboard Katalog**: Menampilkan daftar kue (foto, nama, harga, stok) dalam tampilan grid card Bootstrap.
* **CRUD Data Kue**: Tambah kue dengan upload foto nama unik ke `/uploads/`, edit data (dengan opsi ganti foto), dan hapus data beserta file fotonya.

## Struktur File
* `database.sql` — Struktur database `toko_roti` (tabel `users` & `kue`).
* `koneksi.php` — Konfigurasi koneksi ke MySQL.
* `register.php`, `login.php`, `logout.php` — Manajemen akun & session admin.
* `dashboard.php`, `tambah_kue.php`, `edit_kue.php`, `hapus_kue.php` — Halaman utama dan operasi CRUD katalog kue.
* `uploads/` — Folder penyimpanan foto kue.

## Cara Menjalankan
1. Simpan folder proyek ke `htdocs` (XAMPP) atau `www` (Laragon), lalu jalankan **Apache** dan **MySQL**.
2. Buka `phpMyAdmin` dan import file `database.sql` untuk membuat database `toko_roti`.
3. Sesuaikan konfigurasi di `koneksi.php` jika berbeda dari default (`root` tanpa password).
4. Buka `http://localhost/nama-folder-proyek/register.php` di browser untuk membuat akun admin, lalu login melalui `login.php`.
