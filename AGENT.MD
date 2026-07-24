# Agent Context & Rules - Sistem Monitoring Material (Medina Residence)

## 🚀 Overview Project

Fokus utama pengembangan sistem **Medina Residence** adalah menerapkan fitur **Keamanan Data dan Informasi**, **Notifikasi Otomatis**, serta **Pengelolaan Profil Pengguna** pada modul yang ada.

---

## 📌 Menu Navigasi & Modul Terkait

Sistem terdiri dari modul-modul berikut (sesuai `layouts/sidebar.blade.php`):
1. **Dashboard** (Admin & Mandor)
2. **Profil** (Admin & Mandor) -> *Menu formal profil pengguna & upload foto profil*
3. **Master Data (Khusus Admin)**:
   - Data User (`users`)
   - Data Tipe Unit (`type_units`)
   - Data Kawasan (`kawasans`)
   - Data Supplier (`suppliers`)
   - Data Material (`materials`)
4. **Transaksi (Admin & Mandor)**:
   - Material Masuk (`material_masuk`)
   - Material Terpakai (`material_terpakai`)
5. **Laporan (Admin & Mandor)**:
   - Pengajuan Laporan (`laporans` status: diajukan/disetujui/ditolak)
   - Data Laporan & Print PDF (`laporans`)

---

## 🔒 Mandatory Security Standards & Requirements

### 1. Data Encryption (Data Protection)
- Gunakan Attribute Casting `'encrypted'` pada Model Laravel atau `Crypt::encryptString()` / `Crypt::decryptString()`.
- **Kolom Wajib Di-encrypt (Hanya Kolom yang Ada di Database/View):**
  - **Model `User`**: `email`
  - **Model `Supplier`**: `no_hp`, `alamat_supplier`
- **Aturan Strict**: Dilarang menambah kolom baru yang tidak ada pada database/view saat ini (seperti `no_resi`). Pastikan data sensitif yang ada tidak tersimpan dalam bentuk *plaintext* di database.

### 2. Login Attempt Limiter (Security Monitoring / Rate Limiting)
- Terapkan fitur **Login Attempt Limiter** menggunakan `Illuminate\Support\Facades\RateLimiter` di `AuthController::login()`.
- **Batas Percobaan**: Maksimal **3 kali percobaan login yang gagal** per kombinasi Email + IP Address.
- **Durasi Lockout**: Jika gagal 3 kali, kunci proses login selama **30 detik**.
- **Notifikasi Error**: Tampilkan pesan error beserta hitung mundur sisa detik (*seconds remaining*) kepada pengguna: *"Terlalu banyak percobaan login yang gagal. Silakan tunggu [N] detik lagi."*

### 3. User Profile Management & Login Guard (Profil Pengguna & Upload Foto)
- **Menu Sidebar**: Tambahkan menu **Profil** di `layouts/sidebar.blade.php` untuk role **Admin** maupun **Mandor** (Cukup 1 item menu saja, form pengeditan ada di dalam halaman profil tersebut).
- **Konten Halaman Profil**:
  - Tampilan formal data profil pengguna (Nama, Email, Role, Status, Foto Profil).
  - Fitur upload & perbarui foto profil (`avatar` / `foto`).
- **Alur Login Guard & SweetAlert**:
  - Setelah user berhasil login, periksa apakah profil/foto profil sudah dilengkapi.
  - Jika profil belum dibuat/dilengkapi, pemicu **SweetAlert** wajib muncul menginformasikan bahwa user harus melengkapi profil terlebih dahulu, lalu otomatis mengarahkan (*redirect*) user ke halaman Form Profil.
- **Notifikasi Berhasil (Toast)**:
  - Setelah berhasil memperbarui/menyimpan data profil dan foto, gunakan notifikasi **Toast** yang sudah tersedia di template/sistem untuk memberikan konfirmasi sukses.

---

## 🛠️ Code Conventions & Guidelines
- Gunakan struktur standar Laravel (Controllers, Models, Form Requests, Mailables/Notifications, Blade Views).
- Pertahankan **Input Validation** serta **Password Hashing** (`Hash::make()`).
- **Aturan Validasi Password User**: Pembuatan atau perubahan password di menu Tambah/Edit User wajib divalidasi dengan aturan: Minimal 6 karakter, **diawali huruf besar (kapital)**, serta **mengandung kombinasi huruf dan angka** (regex `/^[A-Z](?=.*[0-9]).+$/`, contoh: `Admin123`).
- Berikan instruksi perubahan file `.env` jika memerlukan konfigurasi baru (SMTP Mail Server).
- Selalu periksa dan gunakan file/kolom yang sudah ada di project tanpa menambah kolom/tabel baru yang tidak perlu.
