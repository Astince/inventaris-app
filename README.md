Sistem Inventaris Barang Berbasis Web

Aplikasi inventaris barang berbasis web yang dikembangkan menggunakan framework Laravel untuk mendukung pengelolaan data inventaris barang pada Kantor BAN-PDM Provinsi Papua Barat.

Proyek ini dibuat sebagai Tugas Akhir pada program studi D3 Teknik Komputer.

Tentang Proyek

Sistem ini dirancang untuk membantu pengelolaan data inventaris barang melalui aplikasi web. Sistem memiliki dua jenis hak akses, yaitu Super Admin dan Operator, sesuai dengan kewenangan masing-masing pengguna.

Fitur Utama

1. Pengelolaan data inventaris barang.
2. Pengelolaan data melalui antarmuka berbasis web.
3. Hak akses pengguna berdasarkan peran Super Admin dan Operator.
4. Pencatatan transaksi inventaris.
5. Penyajian laporan inventaris.

Teknologi yang Digunakan

1. Bahasa pemograman            : PHP
2. Framework                    : Laravel
3. Database                     : MySQL
4. Frontend                     : HTML, CSS, JavaScript, dan Tailwind CSS
5. Code editor                  : Visual Studio Code
6. Local development environment: Laragon
7. Version control              : Git dan GitHub

Dokumentasi Proyek

1. Laporan Tugas Akhir (PDF)
2. Buku Panduan Pengguna

Menjalankan Aplikasi Secara Lokal

Pastikan PHP, Composer, Node,js, npm, dan MySQL telah tersedia pada komputer.
1. Clone repositori ini:
   git clone https://github.com/Astince/inventaris-app.git
2. Masuk ke direktori proyek:
   cd inventaris-app
3. Instal dependensi PHP:
   composer install
4. Salin file konfigurasi lingkungan:
   cp .env.example .env
   Pada Windows, file .env.example juga dapat disalin secara manual menjadi .env.
5. Buat application key:
   php artisan key:generate
6. Buat database MySQL dan sesuaikan konfigurasi database pada file .env.
7. Jalankan migrasi database sesuai kebutuhan proyek:
   php artisan migrate
8. Instal dependensi frontend dan komplikasi aset:
   npm install
   npm run build
9. Jalankan aplikasi:
   php artisan serve
10. Buka alamat lokal yang ditampilkan terminal pada browser.

Catatan: Langkah tambahan mungkin diperlukan sesuai konfigurasi database, data awal, dan kebutuhan aplikasi.

Pengembang

Agustine Babo Djago
Lulusan D3 Teknik Komputer, Agustus 2026.

Proyek ini merupakan bagian dari pengembangan kemampuan dalam perancangan dan pembangunan aplikasi web menggunanakan Laravel.
