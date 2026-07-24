# Sistem Monitoring Material - Medina Residence

Sistem informasi berbasis web yang dikembangkan menggunakan framework Laravel 12 untuk mengelola dan memonitoring material, transaksi material masuk/keluar, pengajuan laporan, serta manajemen pengguna (Admin dan Mandor) pada proyek Medina Residence.

---

## 1. Cara Instalasi

1. Clone atau download repositori proyek ke direktori komputer lokal Anda.
2. Buka terminal atau command prompt pada direktori proyek.
3. Jalankan perintah berikut untuk menginstall dependensi PHP:
   ```bash
   composer install
   ```
4. Jalankan perintah berikut untuk menginstall dependensi Node.js dan aset frontend:
   ```bash
   npm install
   ```
5. Salin file sampel konfigurasi lingkungan `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
6. Buat database baru di MySQL dengan nama `db_medina`.
7. Buka file `.env` dan sesuaikan konfigurasi database berikut:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_medina
   DB_USERNAME=root
   DB_PASSWORD=
   ```
8. Generate Application Key Laravel:
   ```bash
   php artisan key:generate
   ```
9. Jalankan migrasi database untuk membuat seluruh tabel yang dibutuhkan:
   ```bash
   php artisan migrate
   ```

---

## 2. Cara Menjalankan Aplikasi

1. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
2. Jalankan server pengembang aset frontend (opsional):
   ```bash
   npm run dev
   ```
3. Buka web browser Anda dan akses alamat berikut:
   ```text
   http://127.0.0.1:8000/login
   ```

---

## 3. Username dan Password

Berikut adalah daftar kredensial akun pengujian yang tersedia di dalam sistem:

1. Akun Admin Utama:
   - Email: `admin1@gmail.com`
   - Password: `Admin123` (atau password yang dikonfigurasi saat seeder/pendaftaran)
   - Role: Admin
   - Hak Akses: Pengelolaan Master Data (User, Tipe Unit, Kawasan, Supplier, Material), Transaksi Material, Persetujuan Laporan.

2. Akun Mandor:
   - Email: `dani@gmail.com`
   - Password: `dani123` (atau password yang dikonfigurasi saat seeder/pendaftaran)
   - Role: Mandor
   - Hak Akses: Transaksi Material Masuk, Material Terpakai, Pengajuan Laporan.

---

## 4. Teknologi yang Digunakan

1. Framework Backend: Laravel 12 (PHP ^8.2)
2. Database Engine: MySQL
3. Framework dan Library Frontend:
   - Blade Templating Engine
   - Bootstrap 5
   - FontAwesome dan Material Design Icons
   - SweetAlert2
4. Fitur dan Sistem Keamanan Aplikasi:
   - Data Encryption (Enkripsi data sensitif email pengguna, nomor telepon supplier, dan alamat supplier)
   - Brute Force Detection (Deteksi percobaan login gagal berulang kali berbasis kombinasi Email dan IP Address)
   - Login Attempt Limiter (Pembatasan maksimal 3 kali gagal login dengan waktu tunggu lockout 30 detik)
   - Live Countdown Timer dan Form Locking (Penguncian otomatis kolom input dan tombol login saat terblokir)
   - Password Complexity Validation (Validasi password minimal 6 karakter, diawali huruf besar, dan mengandung kombinasi huruf serta angka)
   - User Profile Management dan Login Guard (Pengelolaan profil pengguna, upload foto avatar, dan pemicu SweetAlert wajib isi profil)
   - Browser AutoFill Prevention (Proteksi pengisian otomatis kata sandi tersimpan pada form login dan modal)
