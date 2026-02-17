# Presensi RFID & Payroll System

Sistem manajemen presensi RFID dan penggajian berbasis Laravel 9.

## Fitur
- Login multi-role (Admin, HRD, Finance, Karyawan)
- Presensi RFID real-time
- Auto alpha generator
- Cuti & sakit approval
- Payroll otomatis harian
- Approval payroll
- Slip gaji PDF
- Audit log
- Statistik dashboard

## Instalasi

1. Clone repo
2. composer install
3. npm install
4. copy .env.example menjadi .env
5. php artisan key:generate
6. php artisan migrate
7. php artisan storage:link
8. php artisan serve
