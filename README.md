# UTS PEWEB 252410103091

## Academic Task & Project Progress Tracker for Teams

Aplikasi sederhana berbasis **Laravel 13** dan **Blade** untuk memantau tugas, proyek, modul pembelajaran, serta profil tim akademik.

### Fitur

- Login dengan username yang diteruskan sebagai request parameter.
- Dashboard berisi statistik dan daftar proyek.
- Pengelolaan modul pembelajaran dan proyek (tambah, ubah status, hapus).
- Profile dengan keahlian dan aktivitas yang bisa ditambah, diedit, dan dihapus.
- Data proyek pada Dashboard tersinkron dengan halaman Pengelolaan melalui `localStorage`.

### Struktur Utama

```text
routes/web.php
app/Http/Controllers/PageController.php
resources/views/layouts/app.blade.php
resources/views/login.blade.php
resources/views/dashboard.blade.php
resources/views/pengelolaan.blade.php
resources/views/profile.blade.php
resources/views/components/navbar.blade.php
resources/views/components/footer.blade.php
```

### Menjalankan di Laragon

```bash
cd "C:\laragon\www\PEWEB UTS (Versi Praktikum)"
php artisan serve
```

Buka `http://127.0.0.1:8000/login`.

### Catatan

- File `.env`, `vendor`, dan `node_modules` tidak disertakan ke repository.
- Jalankan `composer install` lalu salin `.env.example` menjadi `.env` jika ingin menjalankan project di komputer lain.
