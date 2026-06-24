@echo off
echo ================================================
echo   Baby Jesus Family - Database Setup Script
echo ================================================
echo.

echo [1/4] Creating database...
d:\xampp\mysql\bin\mysql.exe -u root -P 3307 -e "CREATE DATABASE IF NOT EXISTS baby_jesus_family CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if %errorlevel% neq 0 (
    echo ERROR: Could not connect to MySQL. Make sure XAMPP MySQL is running!
    pause
    exit /b 1
)
echo Database created successfully.

echo.
echo [2/4] Running migrations...
php artisan migrate --force
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    pause
    exit /b 1
)
echo Migrations completed.

echo.
echo [3/4] Seeding database...
php artisan db:seed --force
if %errorlevel% neq 0 (
    echo ERROR: Seeding failed!
    pause
    exit /b 1
)
echo Database seeded.

echo.
echo [4/4] Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo Caches cleared.

echo.
echo ================================================
echo   SETUP COMPLETE!
echo ================================================
echo.
echo Login credentials:
echo   Admin   - admin@babyjesusfamily.com / Admin@1234
echo   Teacher - teacher@babyjesusfamily.com / Teacher@1234
echo.
echo Access URL: http://localhost/BabyJesusFamily/public/login
echo.
pause
