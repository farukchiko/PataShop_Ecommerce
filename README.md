<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🛍️ PataShop - Enterprise E-Commerce Platform

**PataShop** adalah platform E-Commerce modern berskala *enterprise*. Sistem ini dibangun secara independen dengan fokus pada performa yang tangguh, antarmuka pengguna yang estetik, dan keamanan transaksi menggunakan *framework* **Laravel 12**.

---

## 👨‍💻 Developer
**Muhammad Paruk**
*(Solo Developer)*

---

## ✨ Fitur Utama

Sistem PataShop telah dirancang untuk memenuhi kebutuhan toko *online* modern dari dua sisi pengguna (Pembeli dan Administrator):

### 🛡️ Administrator (*Back-Office*)
- **Manajemen Produk (CRUD)**: Kontrol penuh atas katalog produk, termasuk unggah banyak gambar (*multiple image upload*), harga, deskripsi, dan pelacakan stok otomatis.
- **Validasi Transaksi Dompet Digital (Top-Up)**: Panel khusus untuk menyetujui atau menolak pengajuan pengisian dana (*top-up*) dari pelanggan.
- **Pusat Manajemen Pesanan**: Pembaruan status pesanan (*Pending, Packing, Shipped, Completed*) secara dinamis kepada pengguna.
- **Dasbor Penjualan Terintegrasi**: Laporan pendapatan bersih secara *real-time* yang menarik data langsung dari riwayat transaksi.

### 🛒 Pembeli (*Frontend*)
- **E-Wallet System**: Pengguna memiliki dompet digital internal yang memfasilitasi transaksi instan (*zero-latency checkout*) tanpa *payment gateway* pihak ketiga. Saldo awal secara otomatis Rp 0 dan pengisian dana harus disetujui Admin.
- **Sistem Keranjang Cerdas**: Manajemen keranjang belanja dengan deteksi batas stok.
- **Checkout & Riwayat Cerdas**: Struk digital terperinci (*Order Details*) yang mengunci harga pada saat transaksi.
- **Sistem Status Otomatis (Cron Job)**: Pelacakan status pengiriman (*Tracking*), jika pesanan tidak dikonfirmasi selama 3 hari sejak barang dikirim, *cron-job* akan secara otomatis mengubah statusnya menjadi selesai.

---

## 🛠️ Tech Stack & Arsitektur

- **Backend**: Laravel 12.x (PHP 8.3)
- **Database**: MySQL (Relational Database Architecture dengan `UUID` primary keys)
- **Frontend / UI**: Blade Templates, **Tailwind CSS 4.x** (Desain modern kustom responsif), Alpine.js
- **Authentication**: Laravel Breeze (Role-Based Access Control)
- **Task Scheduling**: Laravel Cron Jobs (`Schedule::command`)

---

## ⚙️ Instalasi & Setup (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan PataShop di komputer lokal Anda:

1. **Clone repository:**
   ```bash
   git clone https://github.com/farukchiko/patashop-backend.git
   cd patashop-backend
   ```

2. **Install Dependensi PHP & Node.js:**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database:**
   Buat *database* MySQL kosong (misalnya `patashop_db`), lalu sesuaikan kredensial di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=patashop_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan Migrasi & Seeder Database:**
   *(Pastikan Storage Link diaktifkan untuk manajemen gambar)*
   ```bash
   php artisan storage:link
   php artisan migrate:fresh --seed
   ```

6. **Jalankan Server Lokal & Aset:**
   Buka dua terminal dan jalankan:
   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```

7. **Akses Aplikasi:**
   Buka `http://localhost:8000` di *browser* Anda.

---
*Dikembangkan dengan ☕ dan ❤️ oleh Muhammad Paruk.*
