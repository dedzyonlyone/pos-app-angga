# 🛒 POS App - Point of Sale System (Laravel 13)

Aplikasi Point of Sale (POS) berbasis web yang dirancang khusus untuk memenuhi standar operasional minimarket/toko ritel. Dibangun dari nol menggunakan **Laravel 13 (Monolith)**, **Bootstrap 5**, dan **Vanilla JavaScript** tanpa menggunakan *admin panel generator*.

Aplikasi ini mencakup seluruh modul wajib (M1-M11) dan modul bonus (B1-B3) sesuai standar kompetensi Praktik Kerja Lapangan (PKL).

---

## 📑 Daftar Isi
1. [Fitur Utama](#-fitur-utama)
2. [Modul Bonus](#-modul-bonus)
3. [Tech Stack](#️-tech-stack)
4. [Arsitektur & Struktur Database](#️-arsitektur--struktur-database)
5. [Cara Instalasi](#-cara-instalasi-local-development)
6. [Akun Demo](#-akun-demo)
7. [Menjalankan Testing](#-menjalankan-testing)

---

## ✨ Fitur Utama (M1 - M11)

- **M1: Autentikasi & Hak Akses**: Login/logout dengan session Laravel, pembatasan percobaan login (Rate Limiter), dan pembatasan hak akses antara Admin dan Kasir via Middleware (`EnsureRole`).
- **M2: Dashboard**: Ringkasan penjualan harian, jumlah transaksi, produk aktif, dan alert stok menipis.
- **M3 & M4: Master Data**: CRUD Kategori dan Produk. Produk dilengkapi fitur upload gambar, validasi harga jual (tidak boleh di bawah modal), filter kategori, dan status stok menipis.
- **M5 & M6: Pelanggan & Supplier**: Manajemen data pelanggan dan supplier beserta validasi format nomor HP.
- **M6: Stok Masuk (Purchases)**: Transaksi *Master-Detail* (satu dokumen banyak item) yang dibungkus dengan `DB::transaction()` untuk menjamin konsistensi pengurangan/penambahan stok.
- **M7: Transaksi Kasir (Point of Sale)**:
  - Antarmuka kasir modern dengan katalog produk dan keranjang interaktif (Vanilla JS).
  - Pembatasan stok menggunakan *Pessimistic Locking* (`lockForUpdate`) untuk mencegah *race condition* (oversold).
  - **Auto-Gateway QRIS**: Pop-up QRIS dengan hitungan waktu (*countdown timer*) 60 detik.
  - Instruksi Transfer Bank otomatis.
- **M8: Riwayat & Struk**: Filter tanggal, invoice, dan kasir. Desain halaman struk presisi untuk kertas thermal 80mm (`window.print`).
- **M9: Laporan Penjualan**: Query agregasi (SUM, COUNT, GROUP BY) untuk menampilkan omzet, laba kotor, 10 produk terlaris, dan peringatan stok.
- **M10 & M11: Manajemen User & Pengaturan**: CRUD user dengan enkripsi password, fitur ubah password mandiri, serta pengaturan profil toko berbasis *key-value*.

## 🏆 Modul Bonus (B1 - B3)

- **B1: Export Excel**: Laporan penjualan dapat di-*export* ke format `.xlsx` menggunakan *package* `maatwebsite/excel`.
- **B2: Void Transaksi**: Fitur pembatalan transaksi oleh Admin dengan alasan tertentu, dibungkus `DB::transaction()` untuk mengembalikan stok produk secara otomatis.
- **B3: Log Aktivitas**: Mencatat setiap aksi Create, Update, Delete, dan Void ke dalam tabel `activity_logs` beserta data lama dan baru.

---

## 🛠️ Tech Stack

- **Framework**: Laravel 13 (PHP 8.3+)
- **Database**: MySQL 8 (InnoDB, `utf8mb4_unicode_ci`)
- **Tampilan**: Blade Template, Bootstrap 5, Bootstrap Icons, CSS Kustom (Animasi modern)
- **JavaScript**: Vanilla JS (interaksi kasir), SweetAlert2 (Pop-up QRIS)
- **Testing**: PHPUnit (8 Feature Test)
- **Tools**: Draw.io (ERD), Git/GitHub, Laragon, VS Code

---

## ⚙️ Arsitektur & Struktur Database

Aplikasi ini mengadopsi pola arsitektur **MVC (Model-View-Controller)** dan menerapkan 10 tabel utama dengan relasi *One-to-Many*.

### Relasi Utama:
1. **Master ke Transaksi**: `products` terhubung ke `purchase_items` dan `sale_items`.
2. **Header ke Detail**: `sales` (header) memiliki relasi `hasMany` ke `sale_items` (detail), dan `purchases` ke `purchase_items`.
3. **Snapshot Pattern**: Pada tabel `sale_items`, kolom `product_name`, `price`, dan `purchase_price` disalin dari tabel `products` saat transaksi terjadi. Ini bertujuan agar laporan historis (struk lama) tidak berubah saat harga produk di-update di masa depan.
4. **Tipe Data Uang**: Seluruh nominal uang menggunakan tipe `DECIMAL(15,2)` untuk mencegah *floating point error*.

### Struktur Folder Kustom:
- `app/Exports/`: Berisi class `SalesExport` untuk keperluan export Excel.
- `app/Support/`: Berisi helper statis seperti `Rupiah.php` (format mata uang) dan `ActivityLogger.php` (pencatatan log).
- `app/Http/Middleware/EnsureRole.php`: Middleware untuk mengecek role user di sisi server (403 Forbidden).

---

## 🚀 Cara Instalasi (Local Development)

Ikuti langkah berikut untuk menjalankan proyek ini di komputer Anda:

1. **Clone repository ini:**
   ```bash
   git clone https://github.com/dedzyonlyone/pos-app-angga.git
   cd pos-app-angga
