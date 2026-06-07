<div align="center">
  <h1>🏡 Sistem Manajemen Kos Putri Ayuni</h1>
  <p><i>Sistem manajemen pemesanan, pembayaran, dan administrasi kos berbasis web modern dengan dual-panel dashboard.</i></p>
  
  ![Laravel](https://img.shields.io/badge/Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
  ![PHP](https://img.shields.io/badge/PHP_8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
  ![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS_4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
  ![Filament](https://img.shields.io/badge/Filament_v5-FDAE4B?style=for-the-badge&logo=filament&logoColor=black)
  ![Midtrans](https://img.shields.io/badge/Midtrans-Payment-0065B3?style=for-the-badge)
  ![Vite](https://img.shields.io/badge/Vite_7-646CFF?style=for-the-badge&logo=vite&logoColor=white)
</div>

<br/>

## 📖 Ringkasan Proyek

**Kos Putri Ayuni** adalah aplikasi manajemen properti kos terintegrasi yang dirancang untuk mempermudah alur pemesanan kamar oleh calon penghuni dan alur administrasi oleh pemilik kos.

Aplikasi ini mengatasi masalah *double-booking* dengan sistem **"Satu User, Satu Pesanan Aktif"**, memvalidasi identitas pengguna melalui No. KTP, serta menyediakan pengalaman pembayaran secara *seamless* menggunakan **Midtrans Payment Gateway** (mendukung QRIS, Virtual Account, dll).

Di sisi pengelola, tersedia **Dashboard Admin (Filament v5)** yang modern untuk memantau data penghuni, kamar, dan status pembayaran secara *real-time*. Penghuni juga memiliki **Dashboard Resident** tersendiri untuk memantau status kamar, tagihan, dan pengumuman.

---

## ✨ Fitur Utama

### 🌐 Sisi Publik (Landing Page)
- 🏠 **Landing Page Modern**: Halaman depan dengan hero section, galeri kamar, area sekitar, dan testimoni. Dilengkapi animasi GSAP & ScrollTrigger.
- 📍 **Peta Lokasi Interaktif**: Integrasi Leaflet.js dengan *lazy loading* (dimuat saat user scroll) untuk menunjukkan lokasi kos.
- 🛏️ **Detail Kamar**: Halaman detail dengan galeri foto multi-gambar, deskripsi fasilitas, harga, dan rekomendasi kamar lainnya.
- 📱 **Desain Responsif**: Tampilan optimal di mobile, tablet, maupun desktop dengan tema coklat/krem premium.

### 🔐 Sistem Autentikasi
- 🔒 **Registrasi dengan validasi KTP**: User harus memiliki No. KTP unik saat mendaftar.
- 🔑 **Login/Logout**: Sistem login berbasis email & password dengan hashing bcrypt.
- 📧 **Lupa & Reset Password**: Alur reset password lengkap via email token.
- 👥 **Pembatasan Peran**: Tiga peran — `user`, `penghuni` (otomatis saat booking confirmed), `admin`.

### 🛒 Pemesanan & Pembayaran
- 🛍️ **Smart Booking System**: Mencegah user memesan lebih dari satu kamar bersamaan. Dilengkapi detail durasi sewa dan rincian harga.
- 💳 **Pembayaran Otomatis (Midtrans)**: Integrasi Snap API Midtrans untuk berbagai metode pembayaran. Memiliki sistem *Auto-Retry* cerdas jika user menutup popup pembayaran.
- ⏰ **Auto-Expire Booking**: Pesanan yang belum dibayar otomatis dibatalkan setelah 24 jam melalui scheduler (`booking:expire`) yang berjalan per jam.
- 🧾 **Invoice & Riwayat**: Halaman riwayat pesanan dengan detail invoice dan cetak resi.

### 📱 Notifikasi
- 📲 **WhatsApp Gateway (Fonnte)**: Notifikasi otomatis ke admin saat ada pemesanan baru dan pembayaran berhasil.

### 📊 Dashboard Admin (Filament v5)
- 📈 **Statistik Real-time**: Widget statistik kamar, penghuni aktif, dan total pendapatan dengan lazy loading.
- 📉 **Grafik Pendapatan**: Chart pendapatan bulanan interaktif.
- 📋 **Pemesanan Terbaru**: Tabel booking terkini.
- 🏨 **Kelola Kamar**: CRUD kamar lengkap dengan upload foto multi-gambar (disimpan di `storage/app/public/rooms/`).
- 👤 **Kelola User**: Manajemen data user beserta relasi booking-nya.
- 💰 **Kelola Pembayaran**: Pantau status semua transaksi.
- ⚙️ **Pengaturan & Info**: Halaman Settings untuk mengatur WiFi, pengumuman, dan informasi umum yang tampil di Dashboard Penghuni.

### 🏠 Dashboard Penghuni (Resident Panel)
- 🛏️ **Status Kamar**: Melihat informasi kamar yang sedang disewa beserta foto.
- 📅 **Info Tagihan**: Widget info sewa aktif dan tanggal jatuh tempo.
- 📢 **Pengumuman**: Melihat pengumuman dari admin (WiFi, info, dll).
- 💳 **Riwayat Pembayaran**: Lihat semua transaksi pembayaran yang telah dilakukan.
- ✏️ **Edit Profil**: Ubah nama, email, No. HP, dan password.

### ⚡ Optimasi Performa
- 🖼️ **Lazy Loading Gambar**: Semua `<img>` di seluruh halaman menggunakan `loading="lazy"`.
- 🗺️ **Lazy Loading Peta**: Leaflet.js dimuat secara dinamis saat user scroll mendekati area peta (IntersectionObserver).
- 📊 **Lazy Loading Widget**: Widget Filament (`AdminStatsOverview`, `IncomeChart`, `LatestBookings`) menggunakan `$isLazy = true`.
- 📱 **Room Grid Limiting**: Halaman home menampilkan kamar terbatas (2 baris responsif) dengan tombol "Selengkapnya" dan animasi GSAP.

---

## 🛠️ Tech Stack

| Kategori | Teknologi | Versi |
| :--- | :--- | :--- |
| **Framework** | [Laravel](https://laravel.com/) | 12.x |
| **Admin Panel** | [Filament](https://filamentphp.com/) | v5.0 |
| **Frontend** | Blade Templating + [Tailwind CSS](https://tailwindcss.com/) | Tailwind v4 |
| **Build Tool** | [Vite](https://vitejs.dev/) | 7.x |
| **Database** | MySQL | - |
| **Payment Gateway** | [Midtrans Snap API](https://midtrans.com/) | PHP SDK v2.6 |
| **WhatsApp Gateway** | [Fonnte API](https://fonnte.com/) | - |
| **Animasi** | [GSAP](https://greensock.com/gsap/) + ScrollTrigger | CDN |
| **Peta** | [Leaflet.js](https://leafletjs.com/) | CDN |
| **Font** | [Google Fonts](https://fonts.google.com/) (Inter, Outfit, Playfair Display) | CDN |

---

## 🚀 Panduan Instalasi

### 1. Kebutuhan Sistem (Prerequisites)
- PHP >= 8.2
- Composer
- Node.js >= 18 & NPM
- Database Server (SQLite sudah included, atau MySQL/MariaDB)

### 2. Kloning & Persiapan Proyek
```bash
# Clone repositori
git clone <url-repo-anda> kos-putri-ayuni
cd kos-putri-ayuni

# Install dependensi PHP & Node.js
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
```bash
# Salin file .env contoh (jika ada) dan generate key
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan atur konfigurasi berikut. **⚠️ PENTING: Jangan commit file `.env` ke repositori!**

```env
# --- KONFIGURASI DATABASE ---
DB_CONNECTION=sqlite
# Untuk MySQL, ganti ke:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=kos_putri_ayuni
# DB_USERNAME=root
# DB_PASSWORD=

# --- KONFIGURASI MIDTRANS ---
MIDTRANS_SERVER_KEY=your_midtrans_server_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false

# --- KONFIGURASI WHATSAPP GATEWAY (FONNTE) ---
WHATSAPP_ENABLED=true
FONNTE_API_URL=https://api.fonnte.com/send
FONNTE_API_TOKEN=your_fonnte_api_token
WHATSAPP_ADMIN_PHONE=628xxxxxxxxxx
```

### 4. Migrasi Database & Seeding
```bash
# Buat symbolic link untuk storage
php artisan storage:link

# Jalankan migrasi & seeding
php artisan migrate:fresh --seed
```
> Seeding akan membuat akun admin default dan contoh data kamar.

### 5. Menjalankan Server

**Opsi A — Semua sekaligus (Recommended):**
```bash
composer dev
```
> Menjalankan Laravel server, queue listener, log viewer, dan Vite secara bersamaan.

**Opsi B — Manual (dua terminal):**
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev
```

### 6. Akses Aplikasi
| Halaman | URL |
| :--- | :--- |
| Landing Page | `http://localhost:8000` |
| Halaman About | `http://localhost:8000/about` |
| Login | `http://localhost:8000/login` |
| Dashboard Admin | `http://localhost:8000/admin` |
| Dashboard Penghuni | `http://localhost:8000/resident` |

---

## 📂 Struktur Modul Penting

| Modul / Fungsionalitas | Lokasi File | Deskripsi |
| :--- | :--- | :--- |
| **Pemesanan Kamar** | `app/Http/Controllers/PesananController.php` | Mengatur logika booking, pengecekan duplikasi, & auto-retry Snap Token. |
| **Sistem Pembayaran** | `app/Services/PaymentService.php` | Generate token Midtrans, pengecekan status manual, dan proses callback. |
| **Notifikasi WA** | `app/Services/WhatsAppService.php` | Pengiriman pesan API ke Fonnte (notifikasi Admin). |
| **Auto-Expire** | `app/Console/Commands/ExpireBooking.php` | Scheduler otomatis membatalkan booking > 24 jam belum bayar. |
| **Booking Logic** | `app/Services/BookingService.php` | Service layer untuk logika bisnis booking & expiration. |
| **Settings** | `app/Services/SettingsService.php` | Baca/tulis pengaturan (WiFi, pengumuman) dari file JSON. |
| **Admin Dashboard** | `app/Filament/Pages/AdminDashboard.php` | Halaman utama dashboard admin dengan widget statistik. |
| **Admin Settings** | `app/Filament/Pages/Settings.php` | Form pengaturan WiFi, pengumuman, dan info untuk penghuni. |
| **Resident Dashboard** | `app/Filament/Resident/Pages/ResidentDashboard.php` | Dashboard penghuni: status kamar, tagihan, dan pengumuman. |
| **Custom Avatar** | `app/Filament/AvatarProviders/CustomAvatarProvider.php` | Avatar pengguna kustom berdasarkan inisial nama. |
| **Event Booking** | `app/Events/BookingCreated.php` | Event dipicu saat booking baru dibuat. |
| **Event Payment** | `app/Events/PaymentReceived.php` | Event dipicu saat pembayaran berhasil. |
| **Listener Booking** | `app/Listeners/SendBookingNotification.php` | Kirim WA ke admin saat ada booking baru. |
| **Listener Payment** | `app/Listeners/SendPaymentNotification.php` | Kirim WA ke admin saat pembayaran sukses. |

---

## 🗄️ Model & Database

| Model | Tabel | Deskripsi |
| :--- | :--- | :--- |
| `User` | `users` | Data pengguna: nama, email, No. KTP, No. HP, peran (user/admin). |
| `Room` | `rooms` | Data kamar: nomor, tipe, harga, deskripsi, status (tersedia/tidak tersedia). |
| `RoomImage` | `room_img` | Galeri foto kamar (multi-gambar per kamar, disimpan di storage). |
| `Booking` | `bookings` | Data pemesanan: invoice, check-in, status (pending/confirmed/expired/cancelled). |
| `Payment` | `payments` | Data pembayaran: metode, jumlah, status, snap token Midtrans. |
| `Refund` | `refunds` | Data refund jika ada pembatalan. |
| `BillingPenghuni` | `billing_penghuni` | Data tagihan bulanan penghuni. |

---

## 🔄 Alur Bisnis Utama

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   User       │────▶│   Pilih      │────▶│   Booking    │────▶│   Bayar      │
│   Register   │     │   Kamar      │     │   Created    │     │   (Midtrans) │
└──────────────┘     └──────────────┘     └──────────────┘     └──────┬───────┘
                                                                      │
                                          ┌──────────────┐            │
                                          │   Notifikasi │◀───────────┘
                                          │   WA Admin   │     (callback)
                                          └──────────────┘
                                                │
                                          ┌─────▼────────┐
                                          │   Booking    │
                                          │   Confirmed  │
                                          └──────────────┘
```

**Auto-Expire Flow:**
- Scheduler `booking:expire` berjalan setiap jam (`Schedule::command('booking:expire')->hourly()`)
- Booking dengan status `pending` yang berusia > 24 jam otomatis diubah ke `expired`
- Status kamar dikembalikan ke `tersedia`

---

## 💡 Catatan Pengembangan

### Midtrans Webhook (Production)
Saat deploy ke production, daftarkan URL Webhook di dashboard Midtrans:
```
https://domain-anda.com/payment/notification
```

### Scheduler (Production)
Tambahkan cron job di server:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

### Upload Foto Kamar
Foto kamar disimpan di `storage/app/public/rooms/` dan diakses melalui symbolic link `public/storage`. Pastikan menjalankan `php artisan storage:link`.

### Kustomisasi Koordinat Peta
Koordinat peta di halaman About (`about.blade.php`) saat ini diatur ke:
```
Latitude:  -8.298672035703198
Longitude: 114.29870214765783
```
Ubah di file `resources/views/about.blade.php` pada bagian Leaflet map initialization.

### Pengaturan Admin
Melalui menu **Pengaturan & Info** di dashboard admin, pemilik kos bisa mengatur:
- Nama & password WiFi
- Informasi tambahan
- Pengumuman (akan tampil di Dashboard Penghuni)

Data disimpan di `storage/app/settings.json`.

---

<div align="center">
  <p>Dibuat dengan ❤️ untuk kemudahan manajemen Kos Putri Ayuni.</p>
  <p><sub>Laravel 12 • Filament v5 • Tailwind CSS 4 • Midtrans • Fonnte</sub></p>
</div>
