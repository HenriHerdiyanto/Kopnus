<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
# Job Portal API

Sebuah API sistem manajemen rekrutmen yang dibangun dengan **Laravel 13**. Sistem ini mendukung alur kerja antara Employer (perusahaan) dan Freelancer, serta fitur manajemen pengguna oleh Admin.

## Fitur Utama
- **Autentikasi**: Sistem login dan register dengan token (Sanctum).
- **Manajemen User**: CRUD user dengan pembagian role (Admin, Employer, Freelancer).
- **Manajemen Job**: Employer dapat membuat, mengedit, dan menghapus lowongan pekerjaan.
- **Sistem Pelamaran**: Freelancer dapat melamar pekerjaan dengan mengunggah CV (PDF).
- **Status Lamaran**: Employer dapat melihat daftar pelamar dan melakukan aksi Accept/Reject.

## Cara Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal:

1. **Clone Repository**
   ```bash
   git clone <url-repository-anda>
   cd <nama-folder>
2. **Install Dependencies**
   composer install
3. **Konfigurasi Environment**
sesuaikan .env anda dan php artisan key:generate
4. **Jalankan Migrasi & Seeder**
   php artisan migrate:fresh --seed
5. **Jalankan Server**
   php artisan serve
## List Endpoints
1. Autentikasi <br>
    Method,Endpoint,Deskripsi <br>
    POST,/login,Login pengguna <br>
    POST,/register,Daftar user baru <br>
2. User Management <br>
    Method,Endpoint,Akses <br>
    GET,/users,List semua user <br>
    DELETE,/users/{id},Hapus user (Admin) <br>
3. Job Management <br>
    Method,Endpoint,Deskripsi <br>
    POST,/jobs,Posting lowongan baru <br>
    GET,/jobs,List semua lowongan <br>
    GET,/jobs/my,List lowongan milik employer <br>
    GET,/jobs/{id},Detail lowongan <br>
    PUT,/jobs/{id},Update lowongan <br>
    DELETE,/jobs/{id},Hapus lowongan <br>
4. Application Management <br>
    Method,Endpoint,Deskripsi <br>
    POST,/jobs/{id}/apply,Kirim lamaran (Upload CV) <br>
    GET,/jobs/{id}/applicants,Lihat list pelamar <br>
    PATCH,/applications/{id}/status,Update status (Accept/Reject) <br>
## Catatan Penggunaan
Header Wajib: Untuk semua endpoint yang membutuhkan akses, sertakan Header: <br>
Authorization: Bearer {token_anda} <br>
Accept: application/json <br><br>

Upload CV: <br>
Untuk endpoint POST /jobs/{id}/apply, gunakan format form-data. <br>
Key: cv, Type: file, Value: [pilih file pdf] <br><br>

Status Update: <br>
Untuk PATCH /applications/{id}/status, kirimkan JSON body: <br>
{
  "status": "accepted"
}
