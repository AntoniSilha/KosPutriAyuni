# 📂 Struktur Folder Kos Putri Ayuni

Dokumen ini menjelaskan secara detail struktur folder dan fungsi dari setiap modul di dalam proyek **Kos Putri Ayuni**. Diperuntukkan bagi developer yang akan melanjutkan pengembangan sistem.

---

## 🏗️ Gambaran Umum

Proyek ini menggunakan **Laravel 12** dengan **Filament v5** sebagai admin panel, **Tailwind CSS v4** untuk styling, dan **Vite 7** sebagai build tool. Arsitektur mengikuti pola **Service Layer** di mana logika bisnis kompleks dipisahkan ke dalam class Service.

```
KosPutriayuni/
├── app/                    # Inti aplikasi (backend logic)
├── bootstrap/              # Bootstrap framework Laravel
├── config/                 # File konfigurasi aplikasi & integrasi
├── database/               # Migrasi, seeder, & file database
├── node_modules/           # Dependensi NPM (auto-generated)
├── public/                 # Aset publik yang dapat diakses browser
├── resources/              # Frontend: views, CSS, JavaScript
├── routes/                 # Definisi rute web & console
├── storage/                # File upload, cache, log
├── vendor/                 # Dependensi Composer (auto-generated)
├── .env                    # Konfigurasi environment (JANGAN commit!)
├── .gitignore              # File yang diabaikan Git
├── composer.json           # Dependensi PHP & script Composer
├── package.json            # Dependensi NPM & script build
├── vite.config.js          # Konfigurasi Vite + Tailwind CSS
├── README.md               # Dokumentasi proyek
└── STRUKTUR_FOLDER.md      # Dokumen ini
```

---

## 📁 Detail Struktur Folder

### 1. `app/` — Inti Aplikasi (Backend Logic)

Semua logika bisnis, koneksi database, dan integrasi API eksternal berada di sini.

```
app/
├── Console/
│   └── Commands/
│       └── ExpireBooking.php           # Artisan command: batalkan booking > 24 jam
├── Events/
│   ├── BookingCreated.php              # Event dipicu saat booking baru dibuat
│   └── PaymentReceived.php             # Event dipicu saat pembayaran berhasil
├── Filament/                           # Semua konfigurasi dashboard Filament
│   ├── AvatarProviders/
│   │   └── CustomAvatarProvider.php    # Avatar kustom berdasarkan inisial nama
│   ├── Pages/
│   │   ├── AdminDashboard.php          # Halaman utama dashboard admin
│   │   └── Settings.php               # Halaman pengaturan WiFi & pengumuman
│   ├── Resident/                       # Panel Penghuni (terpisah dari Admin)
│   │   ├── Pages/
│   │   │   ├── EditProfile.php         # Halaman edit profil penghuni
│   │   │   ├── Payments.php            # Halaman riwayat pembayaran penghuni
│   │   │   └── ResidentDashboard.php   # Dashboard utama penghuni
│   │   └── Widgets/
│   │       └── ActiveLeaseInfo.php     # Widget info sewa aktif
│   ├── Resources/                      # CRUD resources Filament (Admin)
│   │   ├── Bookings/
│   │   │   ├── BookingResource.php     # Resource CRUD pesanan
│   │   │   └── Pages/
│   │   │       ├── CreateBooking.php
│   │   │       ├── EditBooking.php
│   │   │       └── ListBookings.php
│   │   ├── Payments/
│   │   │   ├── PaymentResource.php     # Resource CRUD pembayaran
│   │   │   └── Pages/
│   │   │       ├── CreatePayment.php
│   │   │       ├── EditPayment.php
│   │   │       └── ListPayments.php
│   │   ├── Rooms/
│   │   │   ├── RoomResource.php        # Resource CRUD kamar
│   │   │   ├── RoomImagesRelationManager.php  # Relation manager foto kamar
│   │   │   └── Pages/
│   │   │       ├── CreateRoom.php
│   │   │       ├── EditRoom.php
│   │   │       └── ListRooms.php
│   │   └── Users/
│   │       ├── UserResource.php        # Resource CRUD user
│   │       ├── BookingsRelationManager.php  # Relation manager booking per user
│   │       └── Pages/
│   │           ├── CreateUser.php
│   │           ├── EditUser.php
│   │           └── ListUsers.php
│   └── Widgets/                        # Widget dashboard admin (lazy loaded)
│       ├── AdminStatsOverview.php      # Statistik: kamar, penghuni, pendapatan
│       ├── IncomeChart.php             # Grafik pendapatan bulanan
│       └── LatestBookings.php          # Tabel booking terbaru
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php              # Base controller
│   │   ├── AuthController.php          # Login, register, lupa/reset password
│   │   ├── BookingController.php       # Form & proses pemesanan kamar
│   │   ├── HomeController.php          # Landing page, about, detail kamar
│   │   ├── PaymentController.php       # Callback & redirect dari Midtrans
│   │   └── PesananController.php       # Riwayat pesanan, invoice, snap token
│   ├── Middleware/
│   │   ├── EnsureIsAdmin.php           # Middleware: pastikan user adalah admin
│   │   └── RoleRedirect.php            # Middleware: redirect berdasarkan peran
│   └── Requests/
│       ├── BookingRequest.php          # Validasi form pemesanan
│       └── LoginRequest.php            # Validasi form login
├── Listeners/
│   ├── SendBookingNotification.php     # Kirim WA ke admin saat booking baru
│   └── SendPaymentNotification.php     # Kirim WA ke admin saat bayar sukses
├── Models/
│   ├── User.php                        # Model pengguna (role: user/admin)
│   ├── Room.php                        # Model kamar (status: tersedia/tidak)
│   ├── RoomImage.php                   # Model foto kamar (multi-gambar)
│   ├── Booking.php                     # Model pemesanan (auto-delete cascade)
│   ├── Payment.php                     # Model pembayaran (snap token Midtrans)
│   ├── Refund.php                      # Model refund/pengembalian dana
│   └── BillingPenghuni.php            # Model tagihan bulanan
├── Policies/
│   ├── BookingPolicy.php               # Otorisasi akses data booking
│   └── PaymentPolicy.php              # Otorisasi akses data pembayaran
├── Providers/
│   ├── AppServiceProvider.php          # Provider utama aplikasi
│   └── Filament/
│       ├── AdminPanelProvider.php       # Konfigurasi panel admin (/admin)
│       └── ResidentPanelProvider.php    # Konfigurasi panel penghuni (/resident)
└── Services/                           # Service Layer (logika bisnis terpisah)
    ├── BookingService.php              # Logika booking & auto-expire
    ├── PaymentService.php              # Integrasi API Midtrans (Snap Token)
    ├── SettingsService.php             # Baca/tulis pengaturan dari JSON file
    └── WhatsAppService.php             # Integrasi API Fonnte (WA Gateway)
```

---

### 2. `database/` — Penyimpanan Data

```
database/
├── database.sqlite                     # File database SQLite (default)
├── migrations/
│   ├── create_users_table.php          # Tabel users (nama, email, KTP, HP, role)
│   ├── create_rooms_table.php          # Tabel rooms (nomor, tipe, harga, status)
│   ├── create_room_img_table.php       # Tabel room_img (galeri foto kamar)
│   ├── create_bookings_table.php       # Tabel bookings (invoice, check-in, status)
│   ├── create_payments_table.php       # Tabel payments (metode, jumlah, snap_token)
│   ├── create_refunds_table.php        # Tabel refunds (pengembalian dana)
│   ├── add_foreign_keys_to_*.php       # Foreign key constraints antar tabel
│   └── create_billing_penghuni_table.php  # Tabel tagihan bulanan penghuni
└── seeders/
    └── DatabaseSeeder.php              # Seeder: akun admin default & data kamar
```

> **Catatan:** Untuk menambah kolom baru, selalu buat migration baru (`php artisan make:migration`), jangan mengedit migration yang sudah ada.

---

### 3. `resources/` — Tampilan (Frontend)

Semua file visual yang dilihat oleh User, Penghuni, dan Admin.

```
resources/
├── css/
│   ├── app.css                         # Entry point CSS (Tailwind imports)
│   └── filament/
│       └── kos-panel.css               # Custom CSS untuk panel Filament (tema kos)
├── js/
│   ├── app.js                          # Entry point JavaScript
│   └── bootstrap.js                    # Setup Axios & konfigurasi dasar
└── views/
    ├── home.blade.php                  # Landing page: hero, tentang, kamar, testimoni
    ├── about.blade.php                 # Halaman tentang: profil, fasilitas, peta Leaflet
    ├── auth/
    │   ├── login.blade.php             # Halaman login
    │   ├── register.blade.php          # Halaman registrasi (+ validasi KTP)
    │   ├── forgot-password.blade.php   # Halaman lupa password
    │   └── reset-password.blade.php    # Halaman reset password
    ├── booking/
    │   └── create.blade.php            # Form pemesanan kamar
    ├── room/
    │   └── show.blade.php              # Detail kamar: galeri foto & rekomendasi
    ├── pesanan/
    │   ├── index.blade.php             # Daftar riwayat pesanan user
    │   ├── show.blade.php              # Detail pesanan & tombol "Bayar Sekarang"
    │   └── invoice.blade.php           # Halaman cetak invoice/resi
    ├── layouts/
    │   └── app.blade.php               # Layout utama: navbar, footer, meta SEO
    └── filament/
        ├── pages/
        │   ├── admin-dashboard.blade.php    # Template dashboard admin kustom
        │   └── settings.blade.php           # Template halaman pengaturan
        └── resident/
            └── pages/
                ├── resident-dashboard.blade.php  # Dashboard penghuni kustom
                ├── payments.blade.php            # Riwayat pembayaran penghuni
                └── edit-profile.blade.php        # Template edit profil
```

---

### 4. `routes/` — Jalur Navigasi

```
routes/
├── web.php                             # Rute utama: public, auth, booking, pesanan, payment
└── console.php                         # Scheduler: booking:expire berjalan setiap jam
```

**Struktur Rute `web.php`:**
| Grup | Rute | Controller | Keterangan |
| :--- | :--- | :--- | :--- |
| **Public** | `/` | `HomeController@index` | Landing page |
| | `/about` | `HomeController@about` | Halaman tentang |
| | `/kamar/{id}` | `HomeController@showRoom` | Detail kamar |
| **Auth (guest)** | `/login`, `/register` | `AuthController` | Login & register |
| | `/forgot-password`, `/reset-password/{token}` | `AuthController` | Reset password |
| **Auth (login)** | `/booking` | `BookingController` | Form pemesanan |
| | `/pesanan`, `/pesanan/{id}` | `PesananController` | Riwayat & detail pesanan |
| | `/pesanan/{id}/invoice` | `PesananController@invoice` | Cetak invoice |
| **Payment** | `/payment/notification` | `PaymentController` | Webhook callback Midtrans |
| | `/payment/finish`, `/unfinish`, `/error` | `PaymentController` | Redirect hasil pembayaran |

---

### 5. `config/` — Konfigurasi Aplikasi

```
config/
├── app.php                 # Konfigurasi umum Laravel (timezone, locale, dll)
├── auth.php                # Guard & provider autentikasi
├── cache.php               # Driver cache
├── database.php            # Koneksi database (SQLite/MySQL)
├── filesystems.php         # Disk storage (local, public, s3)
├── livewire.php            # Konfigurasi Livewire (digunakan oleh Filament)
├── logging.php             # Channel logging
├── mail.php                # Konfigurasi email (untuk reset password)
├── midtrans.php            # ⭐ API Keys Midtrans (Server Key, Client Key, mode)
├── queue.php               # Driver antrian
├── services.php            # Konfigurasi layanan pihak ketiga
├── session.php             # Pengaturan session
└── whatsapp.php            # ⭐ Provider Fonnte (API URL, Token, No. HP Admin)
```

---

### 6. `public/` — Aset Publik

Folder yang diakses langsung oleh browser. File yang sudah ter-compile (build) dan gambar statis.

```
public/
├── assets/
│   └── img/
│       ├── about/              # Gambar halaman tentang
│       │   ├── hero_bg.jpeg    #   Background hero section
│       │   ├── interior.jpeg   #   Foto interior kos
│       │   ├── fasilitas.png   #   Foto fasilitas
│       │   └── lingkungan.jpeg #   Foto lingkungan sekitar
│       ├── auth/
│       │   └── auth_bg.jpeg    # Background halaman login/register
│       ├── home/               # Gambar landing page
│       │   ├── hero.png        #   Background hero
│       │   ├── tampilan_kos.jpeg  # Foto tampilan kos
│       │   ├── kampus.jpg      #   Area sekitar: kampus
│       │   ├── cafe.jpg        #   Area sekitar: cafe
│       │   ├── minimarket.jpg  #   Area sekitar: minimarket
│       │   └── hospital.jpg    #   Area sekitar: rumah sakit
│       ├── layout/
│       │   └── og_image.jpeg   # Open Graph image (SEO/share media sosial)
│       └── room/
│           └── room_fallback.jpg  # Gambar fallback jika kamar belum ada foto
├── build/                  # Output Vite build (auto-generated)
├── css/                    # CSS compiled
├── js/                     # JS compiled
├── fonts/
│   └── filament/           # Font kustom panel Filament
├── storage -> storage/app/public  # Symbolic link ke storage (foto upload)
├── favicon.ico             # Favicon website
├── index.php               # Entry point Laravel
├── .htaccess               # Konfigurasi Apache
└── robots.txt              # Instruksi crawler mesin pencari
```

---

### 7. `storage/` — Penyimpanan File

```
storage/
├── app/
│   ├── public/
│   │   ├── avatars/        # Foto profil pengguna (jika ada)
│   │   └── rooms/          # ⭐ Foto kamar yang diupload via dashboard admin
│   ├── private/            # File privat (tidak bisa diakses publik)
│   ├── livewire-tmp/       # File temporary Livewire (upload sementara)
│   ├── tmp/                # File temporary umum
│   └── settings.json       # ⭐ File pengaturan (WiFi, pengumuman) dari admin
├── framework/
│   ├── cache/              # Cache framework
│   ├── sessions/           # Session files
│   └── views/              # Compiled Blade views
└── logs/
    └── laravel.log         # Log aplikasi
```

---

## 🔗 Hubungan Antar Modul

```
┌───────────────────────────────────────────────────────────────────┐
│                        FRONTEND (Blade + Tailwind)                │
│  home.blade.php ─ about.blade.php ─ room/show ─ pesanan/show    │
│  auth/* ─ booking/create ─ pesanan/invoice                       │
└────────────────────────────┬──────────────────────────────────────┘
                             │ HTTP Request
                             ▼
┌───────────────────────────────────────────────────────────────────┐
│                     CONTROLLERS (app/Http/Controllers)            │
│  HomeController ─ AuthController ─ BookingController              │
│  PesananController ─ PaymentController                            │
└────────────────────────────┬──────────────────────────────────────┘
                             │ Delegate
                             ▼
┌───────────────────────────────────────────────────────────────────┐
│                     SERVICES (app/Services)                       │
│  BookingService ─ PaymentService ─ WhatsAppService                │
│  SettingsService                                                  │
└────────────────────────────┬──────────────────────────────────────┘
                             │ Eloquent ORM
                             ▼
┌───────────────────────────────────────────────────────────────────┐
│                     MODELS (app/Models)                            │
│  User ─ Room ─ RoomImage ─ Booking ─ Payment ─ Refund            │
│  BillingPenghuni                                                  │
└───────────────────────────────────────────────────────────────────┘
                             │
                             ▼
┌───────────────────────────────────────────────────────────────────┐
│                     FILAMENT PANELS                               │
│  Admin Panel (/admin) ─────── Resident Panel (/resident)          │
│  ├─ Resources (CRUD)          ├─ ResidentDashboard                │
│  ├─ AdminDashboard            ├─ EditProfile                      │
│  ├─ Settings                  ├─ Payments                         │
│  └─ Widgets (Stats/Chart)     └─ ActiveLeaseInfo Widget           │
└───────────────────────────────────────────────────────────────────┘
```

---

## ⚙️ Konfigurasi Penting

| Item | File | Keterangan |
| :--- | :--- | :--- |
| **Environment** | `.env` | Semua kunci API, koneksi DB, dll. |
| **Midtrans** | `config/midtrans.php` | Server Key, Client Key, mode production. |
| **WhatsApp** | `config/whatsapp.php` | API Fonnte URL, token, nomor admin. |
| **Vite** | `vite.config.js` | Entry points CSS/JS, Tailwind plugin. |
| **Scheduler** | `routes/console.php` | `booking:expire` berjalan tiap jam. |
| **Koordinat Peta** | `resources/views/about.blade.php` | Lat/Lng Leaflet: `-8.2987, 114.2987`. |
| **Pengaturan Kos** | `storage/app/settings.json` | WiFi, pengumuman (dikelola via admin). |
