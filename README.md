# UKMC Smart Todo Web - Pertemuan 11

Project praktikum **Laravel 12** untuk mata kuliah **Pemrograman Basis Mobile - Informatika UKMC**.

Dosen: **Dr. Latius Hermawan, S.T., M.Kom.**

## Fitur
- Register SQL (MySQL)
- Login SQL
- Login Google dengan Laravel Socialite
- CRUD To-Do
- Pemisahan data per user menggunakan `owner_key`
- SQL owner key: `sql_{id}`
- Google owner key: `google_{google_account_id}`
- Tampilan Blade + Bootstrap 5
- Siap dipakai lokal di XAMPP, kemudian dapat dipindah ke hosting

## Persyaratan
- PHP 8.2+
- Composer
- MySQL / MariaDB
- XAMPP boleh digunakan untuk Apache + MySQL

## Instalasi lokal cepat

1. Extract project menjadi:

   `C:\xampp\htdocs\todo_web`

2. Buka PowerShell / CMD:

   ```powershell
   cd C:\xampp\htdocs\todo_web
   composer install
   ```

3. Buat database kosong melalui phpMyAdmin:

   `todo_web`

4. Buat file `.env`:

   PowerShell:
   ```powershell
   Copy-Item .env.example .env
   ```

   CMD:
   ```cmd
   copy .env.example .env
   ```

5. Generate application key:

   ```powershell
   php artisan key:generate
   ```

6. Buat tabel:

   ```powershell
   php artisan migrate
   ```

7. Jalankan:

   ```powershell
   php artisan serve
   ```

8. Buka:

   `http://127.0.0.1:8000`

## Tes awal

### SQL Login
Register akun baru dari `/register`, lalu coba logout dan login kembali.

### Google Login
Buat OAuth Client ID tipe **Web application** pada Google Cloud Console.

Authorized redirect URI lokal:

`http://127.0.0.1:8000/auth/google/callback`

Isi `.env`:

```env
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

Lalu:

```powershell
php artisan optimize:clear
```

## Untuk sinkron dengan Flutter Pertemuan 10

Flutter harus memakai Google Account ID yang sama:

```dart
ownerKey: 'google_${googleUser.id}',
```

bukan Firebase UID.

Untuk akun SQL:
- Laravel: `sql_{users.id}`
- Flutter: `sql_{users.id}`

Jika Laravel dan Flutter diarahkan ke database online yang sama, CRUD dapat terlihat lintas platform setelah refresh.

## Catatan hosting
Pada production, arahkan document root domain/subdomain langsung ke:

`laravel_todo/public`

Jangan expose root project Laravel ke web.
