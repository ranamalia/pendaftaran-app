# Portal Magang Sragen (POMAS)

**Portal Magang Sragen (POMAS)** adalah aplikasi web untuk mengelola **pendaftaran dan pengajuan magang** di lingkungan **Pemerintah Kabupaten Sragen**.

Aplikasi ini ditujukan bagi **siswa SMK dan mahasiswa** sebagai pemohon magang, serta **admin OPD** untuk melakukan verifikasi, persetujuan, dan pengelolaan dokumen magang secara terpusat dan digital.

---

## ✨ Fitur

### Pemohon (SMK / Mahasiswa)
- Registrasi & Login
- Manajemen Profil
- Pengajuan Usulan Magang (maks. 1 aktif)
- Upload & Download Dokumen
- Monitoring Status: Diproses, Disetujui, Ditolak, Selesai

### Admin
- Admin Panel menggunakan **Filament v4**
- Manajemen OPD
- Verifikasi & Persetujuan Pengajuan
- Upload Dokumen Balasan

---

## 🧱 Teknologi

- **Backend**: Laravel 12 (PHP 8.3)
- **Frontend**: Blade Template
- **Styling**: CSS manual
- **Database**: MySQL
- **Admin Panel**: Filament v4
- **Environment**: Laragon (disarankan)

---

## ⚙️ Setup & Menjalankan Aplikasi

1. Clone repository:
```bash
git clone https://github.com/ranamalia/pendaftaran-app.git
cd pendaftaran-app
```

---

### 2️⃣ Install Dependency

```bash
composer install
```

---

### 3️⃣ Setup Environment

Copy file `.env.example` menjadi `.env`

```bash
cp .env.example .env
```

Atur konfigurasi database di `.env`:

```
DB_DATABASE=portal_magang
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4️⃣ Generate App Key

```bash
php artisan key:generate
```

---

### 5️⃣ Migrasi Database

```bash
php artisan migrate
```

Jika ada seeder:

```bash
php artisan db:seed
```

---

### 6️⃣ Storage Link (WAJIB untuk upload file)

```bash
php artisan storage:link
```

---

### 7️⃣ Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di:

```
http://127.0.0.1:8000
```

---

## 📄 Aturan Pengajuan Magang

* Pemohon **hanya boleh punya 1 pengajuan aktif**
* Pemohon **boleh mengajukan ulang** jika status terakhir:

  * `DITOLAK`
  * `SELESAI`
* Jika status:

  * `DIPROSES` / `DISETUJUI`
    → Form terkunci

---

## 📎 Dokumen Pengajuan

### Dokumen Wajib Pemohon

* Surat Pengantar (PDF)
* Transkrip / Rapor (PDF / JPG / PNG)

### Dokumen Opsional

* CV (PDF)
* Proposal (PDF)

### Dokumen Admin

* Surat Jawaban Izin
* Surat Keterangan Selesai

## 👩‍💻 Developer

Dikembangkan oleh:
- **Rizky Amalia Nugrahaeni**
- **Syifa Nur Aini**
---

## 📜 Lisensi

Project ini dikembangkan untuk kebutuhan internal Pemerintah Kabupaten Sragen.
