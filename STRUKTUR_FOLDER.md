# 📂 Struktur Folder Kos Putri Ayuni

Dokumen ini menjelaskan struktur folder dan fungsi dari masing-masing modul di dalam proyek **Kos Putri Ayuni** untuk mempermudah developer melanjutkan pengembangan sistem.

---

## 🏗️ Struktur Utama (Root Directory)
Proyek ini menggunakan standar struktur folder **Laravel 12**. Berikut adalah direktori krusial yang menopang alur bisnis (business logic) aplikasi.

### 1. `app/` (Inti Aplikasi / Backend Logic)
Ini adalah jantung dari aplikasi. Semua logika bisnis, koneksi ke database, dan integrasi API eksternal berada di sini.
- **`app/Console/`**: Tempat menyimpan jadwal perintah otomatis (Cron Jobs) jika diperlukan nantinya.
- **`app/Events/`**: Berisi definisi *Event* (Kejadian). Contoh: `PaymentReceived.php` (dipicu saat pembayaran sukses).
- **`app/Filament/`**: Kumpulan pengaturan **Dashboard Admin**.
  - `Resources/`: Mengatur halaman tabel dan formulir untuk data User, Kamar, Pesanan, dll.
  - `Pages/`: Halaman kustom khusus di dalam dashboard Filament.
  - `Widgets/`: Widget untuk statistik/grafik di halaman depan dashboard admin.
- **`app/Http/`**: Menangani rute web dan permintaan dari luar (HTTP).
  - `Controllers/`: Tempat pemrosesan alur (*Controller*). 
    - `PesananController.php` (Mengelola validasi pemesanan & generate ulang Snap Token).
    - `PaymentController.php` (Menerima respons/callback langsung dari Midtrans).
    - `AuthController.php` (Mengatur login dan pendaftaran penghuni).
- **`app/Listeners/`**: Tempat menaruh fungsi yang bereaksi terhadap *Event*.
  - `SendPaymentNotification.php`: Bertugas mengirimkan WA ke Admin setelah ada *Event* `PaymentReceived`.
- **`app/Models/`**: Penghubung antara aplikasi dengan Database (Tabel User, Kamar, Booking, dll).
- **`app/Providers/`**: Tempat melakukan konfigurasi panel.
  - `Filament/AdminPanelProvider.php`: File pengaturan utama untuk hak akses, warna, dan fitur dashboard Admin.
- **`app/Services/`**: Logika rumit (Layanan Pihak Ketiga) yang dipisahkan agar kode tetap rapi.
  - `PaymentService.php`: Layanan khusus untuk menembak API Midtrans.
  - `WhatsAppService.php`: Layanan khusus untuk menembak API Fonnte (WA Gateway).

### 2. `database/` (Penyimpanan Data)
- **`migrations/`**: Berisi sejarah rancangan database. Jika ingin menambah tabel atau kolom (misalnya menambah kolom KTP), lakukan melalui *migration*.
- **`seeders/`**: Data tiruan (Dummy) atau data awal untuk memasukkan data kamar dan akun Admin secara otomatis (`php artisan db:seed`).

### 3. `resources/` (Tampilan / Frontend)
Menyimpan semua file visual yang dilihat oleh User dan Penghuni.
- **`views/`**: Kode antarmuka (UI) menggunakan teknologi *Blade Templating*.
  - `home.blade.php`: Halaman depan utama (Landing Page).
  - `auth/`: Halaman Login, Register, Lupa Password.
  - `pesanan/`: Halaman riwayat pesanan (index), detail invoice, dan tempat munculnya tombol "Bayar Sekarang" yang memanggil Midtrans Snap JS.
  - `layouts/app.blade.php`: Kerangka utama (Header, Navigasi, Footer) yang digunakan berulang kali.

### 4. `routes/` (Jalur Navigasi)
- **`web.php`**: Buku peta dari aplikasi. File ini mengatur URL mana akan memanggil *Controller* apa (contoh: url `/pesanan` memanggil `PesananController`).

### 5. `config/` (Pengaturan Aplikasi)
- Berisi file konfigurasi bawaan Laravel.
- **`midtrans.php`**: Pengaturan API Keys Midtrans.
- **`whatsapp.php`**: Pengaturan Provider Fonnte dan nomor HP Admin.

### 6. `public/` (Aset Terbuka)
- Folder yang bisa diakses langsung lewat browser. Menyimpan file CSS, JavaScript *compiled* (hasil build Tailwind), dan gambar aset statis.

---

## 🧹 Log Pembersihan (Cleanup Log)
Untuk meringankan kinerja *server* dan *repository*, saya telah menghapus beberapa file sampah (Junk Files) yang tidak lagi relevan:
1. `check*.php` - File-file script PHP mandiri yang sebelumnya digunakan untuk *debugging* (*check.php, check2.php, check_compiled.php*, dll).
2. `resources/views/welcome.blade.php` - Halaman *landing page* bawaan (default) dari instalasi awal Laravel yang sudah tidak dipakai (sudah digantikan oleh `home.blade.php`).
3. `storage/logs/*.log` - Riwayat *log error* lama yang sudah menumpuk agar ruang *storage* aplikasi kembali kosong dan segar.

*Semua pembersihan telah dipastikan tidak mengganggu logika *routing* maupun tampilan sistem Kos Putri Ayuni!* 🚀
