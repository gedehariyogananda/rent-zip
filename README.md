# 👘 Rental Costum App & API

Sistem Informasi Penyewaan Kostum Cosplay berbasis Website (Admin & Member) dan REST API (Mobile/Frontend App). Dibangun menggunakan **Laravel 10**, dilengkapi dengan sistem Manajemen Order, Pembayaran QRIS (Statis), Verifikasi Identitas (KTP/NIK), Katalog Kostum, dan Manajemen Event.

---

## 🛠 Persyaratan Sistem (System Requirements)

Sebelum menginstal, pastikan komputer/server Anda memenuhi persyaratan berikut:
- **PHP** : Versi `>= 8.1`
- **Laravel** : Versi `10.x`
- **Database** : MySQL atau MariaDB
- **Composer** : Versi terbaru
- **Node.js & NPM** : Versi terbaru (untuk meng-compile asset Vite)

---

## 🚀 Langkah-langkah Instalasi (Step-by-Step)

### 1. Persiapan Folder
Buka terminal/CMD, arahkan ke folder project atau extract file project ini, kemudian masuk ke direktori project:
```bash
cd rental-costum
```

### 2. Install Dependensi PHP & Javascript
Jalankan perintah berikut untuk mengunduh semua package yang dibutuhkan:
```bash
composer install
npm install
npm run build
```

### 3. Setup Environment Variable (.env)
Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
*(Di Windows, Anda bisa menggunakan perintah `copy .env.example .env` atau copy-paste manual file tersebut).*

Lalu generate Application Key & JWT Secret:
```bash
php artisan key:generate
php artisan jwt:secret
```

### 4. Konfigurasi Database (MySQL)
1. Buka aplikasi database Anda (XAMPP/PhpMyAdmin/DBeaver/dll) lalu buat database baru dengan nama, contoh: `rental_costum`.
2. Buka file `.env` di text editor (VS Code), lalu ubah baris koneksi database berikut sesuai dengan konfigurasi lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rental_costum
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Konfigurasi Email / SMTP (PENTING)
Aplikasi ini memiliki fitur pengiriman Email/Notifikasi. Anda perlu mengatur SMTP di file `.env`. Anda bisa menggunakan **Mailtrap** (untuk testing) atau **Gmail SMTP** (untuk real email).

**Cara Menggunakan Akun Gmail Asli:**
1. Login ke Akun Google Anda, buka halaman **Manage your Google Account** -> tab **Security**.
2. Aktifkan **2-Step Verification** (Wajib).
3. Setelah aktif, cari menu **App passwords** (atau ketik di kolom pencarian settings).
4. Buat App Password baru (Pilih "Mail" dan "Windows Computer/Other").
5. Google akan memberikan 16 digit password (contoh: `abcd efgh ijkl mnop`).
6. Masukkan email Anda dan 16 digit password tersebut ke dalam file `.env` (hilangkan spasinya):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=emailanda@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=emailanda@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Migrasi Database & Seeding (Dummy Data)
Jalankan perintah ini untuk membangun struktur tabel sekaligus mengisi data awal (dummy kostum, kategori, event, admin, dan user):
```bash
php artisan migrate:fresh --seed
```

### 7. Link Storage
Agar gambar kostum, foto profil, event, dan KTP bisa diakses melalui URL, Anda WAJIB membuat symlink:
```bash
php artisan storage:link
```

### 8. Jalankan Server Lokal
Jalankan perintah ini untuk menyalakan server aplikasi Laravel (Akses Web Admin):
```bash
php artisan serve
```
Buka browser dan akses: [http://localhost:8000](http://localhost:8000)

**Untuk Kebutuhan API Mobile (Flutter / External Device):**
Agar server bisa diakses dari emulator atau HP fisik (Physical Device) yang berada dalam satu jaringan WiFi, jalankan server dengan command berikut:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```
Lalu di aplikasi Flutter, gunakan IP Address lokal komputer Anda untuk endpoint API-nya (contoh: `http://192.168.1.5:8000/api/v1/`).

---

## 🔐 Akun Default (Hasil Seeder)

Setelah menjalankan `migrate:fresh --seed`, Anda bisa menggunakan akun berikut untuk login ke Website CMS maupun via API:

### 👑 Akun Admin (Role 1)
- **Email:** `admin@gmail.com`
- **Password:** `password`

### 👤 Akun Member / User Dummy (Role 2)
- **Email:** `naruto@mail.com` *(Tersedia juga: sakura@mail.com, levi@mail.com, dll)*
- **Password:** `password`

---

## 📱 Ringkasan Dokumentasi API (Untuk Frontend)

Seluruh API berada di dalam Prefix `/api/v1/`. 

**1. Authentication:**
- `POST /login` : Login user (mengembalikan token JWT/Sanctum).
- `POST /register` : Mendaftar akun baru.

**2. Profile & Akun (Wajib Header: `Authorization: Bearer {token}`):**
- `GET /profile` : Get data user & kelengkapan KTP.
- `GET /profile/check` : Mengecek apakah akun `is_verified` (KTP/Alamat lengkap) sebelum mengakses QRIS.
- `POST /profile/update` : Form-Data upload KTP, ubah NIK, Alamat, No Telepon, & Avatar (Opsional).
- `POST /profile/change-password` : Mengubah password lama ke password baru.

**3. Transaksi / Orders (Wajib Header: `Authorization: Bearer {token}`):**
- `GET /orders` : Melihat history pesanan.
- `POST /orders` : Membuat pesanan rental. Otomatis memvalidasi ketersediaan stok & `is_verified` profile.
- `GET /orders/qris` : Mendapatkan URL file `qris.png` statis untuk pembayaran.

**4. Katalog & Events (Public API, Tanpa Token):**
- `GET /costums` : Katalog daftar kostum.
- `GET /events` : Jadwal acara cosplay. Bisa difilter `?status=all` (Akan datang) atau `?status=archived` (Sudah lewat).
- `GET /events/{id}` : Detail event.