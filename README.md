# SIPOLIS - Sistem Informasi Pojok Literasi Statistik

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-EF4223?style=flat-square&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)

SIPOLIS adalah platform web untuk mendukung program literasi statistik **BPS Kota Pekanbaru**. Aplikasi ini menyediakan akses online untuk modul literasi statistik, penjadwalan konsultasi, dan tracking progress belajar.

## 🚀 Fitur Utama

### 🔐 Multi-Role Authentication

- Registrasi dan Login pengguna
- 3 level akses: **User**, **Pengajar**, **Admin**
- Manajemen profil dan ubah password

### 📚 Modul Literasi Statistik

- Download modul PDF berdasarkan kategori (Sosial, Produksi, Distribusi, Neraca)
- Fitur pencarian dan filter modul
- Bookmark modul favorit
- Tracking status modul (diunduh/selesai)

### 📅 Jadwal Konsultasi

- Kalender interaktif (FullCalendar.js)
- Admin membuat jadwal konsultasi
- Pengajar update status selesai

### ✅ Presensi & Daily Check-in

- Daily check-in dengan mood tracker
- Streak belajar berturut-turut 🔥
- Statistik bulanan

### 📊 Dashboard & Progress

- Dashboard khusus untuk setiap role
- Progress belajar dengan persentase
- Statistik modul diunduh & diselesaikan

### 🌙 Fitur Tambahan

- Dark/Light mode
- Responsive design (mobile-friendly)

## 🛠️ Teknologi

| Kategori     | Teknologi                       |
| ------------ | ------------------------------- |
| **Backend**  | PHP 8.x, CodeIgniter 4, MySQL   |
| **Frontend** | HTML5, Tailwind CSS, JavaScript |
| **Library**  | FullCalendar.js, Font Awesome   |
| **Tools**    | Composer, Git                   |

## 📋 Instalasi

### Prasyarat

- PHP 8.1 atau lebih tinggi
- Composer
- MySQL
- XAMPP / Laragon (opsional)

### Langkah Instalasi

1. **Clone repository**

   ```bash
   git clone https://github.com/valll05/sipolis.git
   cd sipolis
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Konfigurasi environment**

   ```bash
   cp env .env
   ```

   Edit file `.env` dan sesuaikan konfigurasi database:

   ```
   database.default.hostname = localhost
   database.default.database = sipolis_db
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   ```

4. **Buat database dan jalankan migrasi**

   ```bash
   php spark migrate
   ```

5. **Jalankan aplikasi**

   ```bash
   php spark serve
   ```

6. Akses aplikasi di `http://localhost:8080`

## 👥 Role & Akses

| Role         | Akses                                         |
| ------------ | --------------------------------------------- |
| **User**     | Akses modul, download, presensi, lihat jadwal |
| **Pengajar** | Dashboard, lihat & update status jadwal       |
| **Admin**    | Kelola modul, user, pengajar, jadwal          |

## 📁 Struktur Folder

```
sipolis/
├── app/
│   ├── Controllers/    # Controller aplikasi
│   ├── Models/         # Model database
│   ├── Views/          # Template view
│   ├── Filters/        # Filter autentikasi
│   └── Config/         # Konfigurasi
├── public/             # Assets publik (CSS, JS, images)
├── writable/           # Cache, logs, uploads
└── vendor/             # Dependencies (Composer)
```

## 📝 Lisensi

MIT License - BPS Kota Pekanbaru © 2026

## 👨‍💻 Developer

Dikembangkan untuk **Pojok Literasi Statistik - BPS Kota Pekanbaru**
