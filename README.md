# Daftar Hadir Online (BPIP)

Selamat datang di **Daftar Hadir Rapat Online** — aplikasi untuk membuat, mengisi, dan merekap daftar hadir kegiatan secara daring untuk sivitas BPIP.  

Akses dimanapun, kapanpun, dengan integrasi SSO-BPIP.  
Penjadwalan, lembar kehadiran, rekap data, semua dalam satu sistem.

---

## 🎯 Fitur

- **Pembuatan Lembar Daftar Hadir**  
  Pengguna dapat membuat lembar kehadiran acara baru, menentukan peserta, waktu, dan pengaturan lainnya.

- **Akses dengan SSO-BPIP**  
  Autentikasi terintegrasi dengan Single Sign-On BPIP untuk kenyamanan dan keamanan.

- **Rekapitulasi Absen**  
  Laporan kehadiran berdasarkan peserta, acara, maupun unit kerja.

- **Antarmuka Web Responsif**  
  UI yang ramah perangkat mobile maupun desktop.

- **Kelola Data Kegiatan**  
  Pembuatan, pengeditan, dan penghapusan aktivitas yang memerlukan kehadiran.

---

## 🛠️ Instalasi & Deploy

Berikut langkah umum untuk menjalankan aplikasi **Daftar Hadir Online**:

```bash
# Clone repo
git clone https://github.com/ardifx01/daftar-hadir-bpip.git
cd daftar-hadir-bpip

# Install dependencies (jika menggunakan Laravel / PHP)
composer install
npm install
npm run dev  # atau build frontend

# Konfigurasi
cp .env.example .env
# Sesuaikan database, domain, dan pengaturan lain di .env

php artisan key:generate
php artisan migrate --seed  # jika ada seeder

# Jalankan server lokal atau deploy ke hosting/web server
php artisan serve   # untuk development
```

---
### 📂 Struktur Direktori
```
daftarhadir/
├── app/                  # Logika aplikasi (Controllers, Models, dll.)
│   ├── Console/          
│   ├── Exceptions/
│   ├── Http/             # Controller, Middleware, Request
│   ├── Models/           # Model Eloquent
│   └── Providers/        # Service providers
│
├── bootstrap/            # Bootstrap Laravel & autoload
│   └── cache/            # Cache framework
│
├── config/               # File konfigurasi (app.php, database.php, dll.)
│
├── database/             # Migration, Seeder, Factory
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/               # Root web server (index.php, assets publik)
│   ├── css/
│   ├── js/
│   └── index.php
│
├── resources/            # File sumber (blade templates, js, css, vue/react)
│   ├── js/
│   ├── lang/
│   └── views/            # Blade templates
│
├── routes/               # Definisi routing (web.php, api.php)
│
├── storage/              # File sementara & cache
│   ├── app/
│   ├── framework/
│   └── logs/
│
├── tests/                # Unit & Feature tests
│
├── vendor/               # Dependensi composer
│
├── .env.example          # Contoh environment config
├── artisan               # CLI Laravel
├── composer.json         # Dependency management (PHP)
├── package.json          # Dependency management (NodeJS)
├── phpunit.xml           # Konfigurasi testing
├── server.php            # Entry point server dev
└── webpack.mix.js        # Laravel Mix (asset bundler)

```

## 📌 Konsep Pengguna & Role

| Role             | Hak Akses                                        |
|------------------|-------------------------------------------------|
| **Admin**        | Kelola acara, peserta, laporan kehadiran        |
| **Peserta**      | Melakukan absensi (menandai kehadiran)          |
| **Auditor/Viewer** | Akses laporan & rekap, tanpa bisa mengubah data |

---

## 📬 Kontak & Dukungan

Jika Anda menemukan bug, ingin fitur tambahan, atau berminat berkontribusi:

- ✉️ Email :  [dhiff26@mnkdigital.tech](mailto:dhiff26@mnkdigital.tech) | [pusdatin@bpip.go.id](mailto:pusdatin@bpip.go.id)
- 🏢 Alamat : Jl. Veteran III No. 2, Jakarta Pusat 10110  
- ☎️ Telepon : (021) 3505200 

---

## 📄 Lisensi

Aplikasi ini dilisensikan di bawah **MIT License**.  
Silakan lihat file [`LICENSE`](LICENSE) untuk detail hak & tanggung jawab.

---

© 2022–2025 **Badan Pembinaan Ideologi Pancasila (BPIP)**  
_All Rights Reserved._
