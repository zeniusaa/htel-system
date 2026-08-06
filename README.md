# htel-system

Sistem pengajuan & verifikasi dokumen pertanahan berbasis web — **Tugas Akhir** (Laravel 12).

## Fitur

- Autentikasi dengan role: **Bank** & **PPAT**
- Pengajuan dokumen beserta upload berkas
- Upload dokumen & bukti bayar
- Verifikasi & update status pengajuan oleh Bank
- Upload SPS (Surat Pernyataan) & arsip pengajuan selesai
- Dashboard per role

## Tech Stack

- Laravel 12
- Blade (server-side rendering)
- MySQL

## Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Bank | bank@mail.com | password |
| PPAT | andi@mail.com | password |

## Cara Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
# atur koneksi database di .env, lalu:
php artisan migrate --seed
php artisan serve
```

Akses `http://localhost:8000`.
