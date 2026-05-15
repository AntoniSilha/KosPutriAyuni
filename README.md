<div align="center">
  <h1>🏡 Sistem Manajemen Kos Putri Ayuni</h1>
  <p><i>Sistem manajemen pemesanan, pembayaran, dan administrasi kos berbasis web modern.</i></p>
  
  ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
  ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
  ![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
  ![Midtrans](https://img.shields.io/badge/Midtrans-Payment-blue?style=for-the-badge)
  ![Filament](https://img.shields.io/badge/Filament-Admin-yellow?style=for-the-badge)
</div>

<br/>

## 📖 Ringkasan Proyek (Project Summary)
**Kos Putri Ayuni** adalah aplikasi manajemen properti (kos) terintegrasi yang dirancang untuk mempermudah alur pemesanan kamar oleh calon penghuni dan alur administrasi oleh pemilik kos. 

Aplikasi ini mengatasi masalah *double-booking* dengan sistem **"Satu User, Satu Pesanan Aktif"**, memvalidasi identitas pengguna melalui No. KTP, serta menyediakan pengalaman pembayaran secara *seamless* menggunakan **Midtrans Payment Gateway** (mendukung QRIS, Virtual Account, dll). Di sisi pengelola, tersedia **Dashboard Admin (Filament)** yang modern untuk memantau data penghuni, kamar, dan status pembayaran secara *real-time*.

---

## ✨ Fitur Utama
Aplikasi ini memiliki beberapa fitur unggulan yang dirancang siap pakai:

- 🔒 **Sistem Autentikasi Kuat**: Registrasi user dengan validasi KTP & pembatasan peran (*User, Penghuni, Admin*).
- 🛍️ **Smart Booking System**: Mencegah user memesan lebih dari satu kamar secara bersamaan. Dilengkapi dengan detail durasi sewa dan rincian harga.
- 💳 **Pembayaran Otomatis (Midtrans)**: Integrasi Snap API Midtrans untuk berbagai metode pembayaran. Memiliki sistem *Auto-Retry* cerdas jika *user* membatalkan/menutup *popup* pembayaran (QRIS).
- 📱 **Notifikasi WhatsApp (Fonnte)**: Pengiriman notifikasi tagihan dan resi pembayaran secara otomatis ke WhatsApp Admin.
- 📊 **Dashboard Filament Admin**: Panel admin super interaktif untuk mengelola Kamar, User, Pemesanan, dan Pembayaran.
- 🖼️ **UI/UX Modern & Responsif**: Tampilan antarmuka yang optimal di *mobile* maupun *desktop* (dibangun dengan Tailwind CSS).

---

## 🛠️ Teknologi yang Digunakan (Tech Stack)
- **Framework**: [Laravel 12](https://laravel.com/)
- **Frontend**: Blade Templating, [Tailwind CSS](https://tailwindcss.com/)
- **Admin Panel**: [Filament v3](https://filamentphp.com/)
- **Database**: MySQL / SQLite (Bisa disesuaikan di `.env`)
- **Payment Gateway**: [Midtrans](https://midtrans.com/)
- **WhatsApp Gateway**: [Fonnte API](https://fonnte.com/)

---

## 🚀 Panduan Instalasi (Untuk Developer Baru)

Jika Anda ingin melanjutkan pengembangan proyek ini, ikuti langkah-langkah instalasi berikut:

### 1. Kebutuhan Sistem (Prerequisites)
Pastikan Anda sudah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database Server (MySQL/MariaDB)

### 2. Kloning & Persiapan Proyek
```bash
# Clone repositori ini (ganti URL jika menggunakan git)
git clone <url-repo-anda> kos-putri-ayuni

# Masuk ke direktori proyek
cd kos-putri-ayuni

# Install dependensi PHP & Node.js
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Buat file `.env` secara manual di root proyek, lalu isi dengan konfigurasi berikut:
```bash
php artisan key:generate
```

Buka file `.env` dan atur konfigurasi sesuai kebutuhan Anda. **⚠️ PENTING: Jangan commit file `.env` ke repositori!**

```env
# --- KONFIGURASI DATABASE ---
DB_CONNECTION=nama_koneksi_anda
DB_HOST=host_database_anda
DB_PORT=port_database_anda
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda

# --- KONFIGURASI MIDTRANS ---
MIDTRANS_SERVER_KEY=your_midtrans_server_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false

# --- KONFIGURASI WHATSAPP GATEWAY (FONNTE) ---
WHATSAPP_ENABLED=true
FONNTE_API_URL=your_fonnte_api_url
FONNTE_API_TOKEN=your_fonnte_api_token
WHATSAPP_ADMIN_PHONE=your_admin_phone_number
```

### 4. Migrasi Database & Seeding
Jalankan migrasi untuk membangun struktur tabel:
```bash
php artisan migrate:fresh --seed
```
*(Proses seeding akan membuatkan akun admin default dan beberapa contoh kamar).*

### 5. Menjalankan Server
Jalankan dua perintah ini di dua terminal terpisah:
```bash
# Terminal 1: Menjalankan server Laravel
php artisan serve

# Terminal 2: Menjalankan Vite (Asset bundler Tailwind CSS)
npm run dev
```
Aplikasi kini dapat diakses di: `http://localhost:8000`

---

## 📂 Struktur Modul Penting
Untuk membantu navigasi bagi developer selanjutnya, berikut adalah lokasi file krusial yang mengatur alur bisnis aplikasi:

| Modul / Fungsionalitas | Lokasi File | Deskripsi |
| :--- | :--- | :--- |
| **Sistem Pembayaran** | `app/Services/PaymentService.php` | Menangani *generate* token Midtrans dan pengecekan status manual. |
| **Pemesanan Kamar** | `app/Http/Controllers/PesananController.php` | Mengatur logika *booking*, pengecekan duplikasi pemesanan, & auto-retry *Snap Token*. |
| **Notifikasi WA** | `app/Services/WhatsAppService.php` | Sistem pengiriman pesan API ke Fonnte (hanya untuk Admin). |
| **Event Listener** | `app/Listeners/SendPaymentNotification.php` | *Trigger* otomatis setelah pembayaran di Midtrans sukses (`approve`). |
| **Admin Dashboard** | `app/Filament/Resources/*` | Tempat Anda menambahkan/mengedit panel CRUD Filament. |

---

## 💡 Catatan Tambahan (Pengembangan Kedepan)
- **Midtrans Webhook**: Saat proyek ini di-*deploy* ke *production* (hosting/VPS), pastikan untuk memasukkan URL Webhook (`https://domain-anda.com/payment/notification`) ke dalam *dashboard* Midtrans agar pembaruan status pembayaran berjalan sepenuhnya otomatis.
- **Auto-Cancel Booking**: Booking akan otomatis dibatalkan jika melebihi batas waktu 24 jam. Ini sudah diatur dalam model Booking (fungsi `isExpired()`).

---
<div align="center">
  <p>Dibuat dengan ❤️ untuk kemudahan manajemen Kos Putri Ayuni.</p>
</div>
