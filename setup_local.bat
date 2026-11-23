@echo off
title UKMC Smart Todo - Setup Lokal
echo ==========================================
echo UKMC SMART TODO WEB - LARAVEL 12
echo ==========================================
echo.
echo Pastikan database "todo_web" sudah dibuat di phpMyAdmin.
echo.

where composer >nul 2>nul
if errorlevel 1 (
    echo ERROR: Composer tidak ditemukan pada PATH.
    pause
    exit /b 1
)

where php >nul 2>nul
if errorlevel 1 (
    echo ERROR: PHP tidak ditemukan pada PATH.
    pause
    exit /b 1
)

echo [1/4] Composer install...
call composer install
if errorlevel 1 goto error

if not exist .env (
    echo [2/4] Membuat .env dari .env.example...
    copy .env.example .env >nul
) else (
    echo [2/4] .env sudah ada.
)

echo [3/4] Generate APP_KEY...
php artisan key:generate
if errorlevel 1 goto error

echo [4/4] Migration database...
php artisan migrate
if errorlevel 1 goto error

echo.
echo ==========================================
echo SETUP SELESAI
echo ==========================================
echo Jalankan:
echo php artisan serve
echo.
echo Buka:
echo http://127.0.0.1:8000
echo.
pause
exit /b 0

:error
echo.
echo SETUP GAGAL. Baca pesan error di atas.
echo Lihat SETUP_LOKAL.txt untuk troubleshooting.
pause
exit /b 1
