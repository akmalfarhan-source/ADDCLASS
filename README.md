# Sistem Manajemen UMKM dan Produk Lokal

Sistem berbasis web untuk pendataan dan promosi UMKM beserta produk lokal menggunakan Laravel 12.

## Fitur Utama

- ✅ **Manajemen UMKM** - CRUD lengkap data UMKM (nama, alamat, kontak, deskripsi, logo)
- ✅ **Manajemen Produk** - CRUD produk dengan relasi ke UMKM
- ✅ **Kategori Produk** - Pengelolaan kategori dengan relasi many-to-many
- ✅ **Upload Foto Produk** - Multiple foto dengan validasi tipe dan ukuran
- ✅ **Pencarian Produk** - Berdasarkan nama, kategori, atau UMKM
- ✅ **Dashboard Admin** - Statistik dan chart pertumbuhan data
- ✅ **Dashboard UMKM Owner** - Kelola produk UMKM sendiri
- ✅ **Autentikasi** - Login terpisah untuk Admin dan Pemilik UMKM
- ✅ **Desain Responsif** - Modern dan mobile-friendly

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL / SQLite

## Instalasi

### 1. Clone Repository

```bash
cd /path/to/project
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` untuk konfigurasi database:

```env
DB_CONNECTION=sqlite
# atau untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=umkm_db
# DB_USERNAME=root
# DB_PASSWORD=
```

### 4. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

### 5. Buat Storage Link

```bash
php artisan storage:link
```

### 6. Build Assets

```bash
npm run build
```

### 7. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## Akun Default

| Role | Email | Password |
|------|-------|----------|
| Administrator | admin@umkm.test | password |
| Pemilik UMKM | owner@umkm.test | password |

## Struktur Menu

### Admin Panel (`/admin/*`)
- Dashboard - Statistik, chart, dan data terbaru
- Data UMKM - Kelola semua UMKM
- Produk - Kelola semua produk
- Kategori - Kelola kategori produk

### UMKM Panel (`/umkm-panel/*`)
- Dashboard - Informasi UMKM dan statistik produk
- Produk Saya - Kelola produk milik sendiri

### Halaman Publik
- Beranda - Landing page dengan produk unggulan
- Pencarian Produk - Filter dan cari produk
- Detail Produk - Informasi lengkap produk dan UMKM

## Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Bootstrap 5
- **Database**: SQLite (default) / MySQL
- **Icons**: Bootstrap Icons
- **Charts**: Chart.js
- **Font**: Inter (Google Fonts)

## Struktur Database

```
users (id, name, email, password, role)
  └── umkm (id, user_id, nama, alamat, telepon, email, deskripsi, logo, is_active)
        └── products (id, umkm_id, nama, deskripsi, harga, stok, is_active)
              ├── product_photos (id, product_id, photo_path, is_primary)
              └── category_product (category_id, product_id)

categories (id, nama, deskripsi, slug)
```

## Validasi Upload Foto

- Format: JPG, PNG, GIF
- Ukuran maksimal: 2MB per foto
- Maksimal 5 foto per produk

## Hak Akses

| Fitur | Admin | UMKM Owner |
|-------|-------|------------|
| Dashboard Admin | ✅ | ❌ |
| Kelola semua UMKM | ✅ | ❌ |
| Kelola semua Produk | ✅ | ❌ |
| Kelola Kategori | ✅ | ❌ |
| Dashboard UMKM | ❌ | ✅ |
| Kelola Produk Sendiri | ❌ | ✅ |

## License

MIT License
