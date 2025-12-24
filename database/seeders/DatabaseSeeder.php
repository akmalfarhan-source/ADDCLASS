<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@umkm.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Categories
        $categories = [
            ['nama' => 'Makanan', 'deskripsi' => 'Produk makanan dan kuliner', 'slug' => 'makanan'],
            ['nama' => 'Minuman', 'deskripsi' => 'Produk minuman', 'slug' => 'minuman'],
            ['nama' => 'Kerajinan Tangan', 'deskripsi' => 'Produk kerajinan tangan dan handmade', 'slug' => 'kerajinan-tangan'],
            ['nama' => 'Fashion', 'deskripsi' => 'Produk pakaian dan aksesoris', 'slug' => 'fashion'],
            ['nama' => 'Pertanian', 'deskripsi' => 'Produk hasil pertanian', 'slug' => 'pertanian'],
            ['nama' => 'Herbal', 'deskripsi' => 'Produk herbal dan jamu', 'slug' => 'herbal'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create UMKM Owner 1
        $owner1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'owner@umkm.test',
            'password' => Hash::make('password'),
            'role' => 'umkm_owner',
        ]);

        $umkm1 = Umkm::create([
            'user_id' => $owner1->id,
            'nama' => 'Warung Makan Sederhana',
            'alamat' => 'Jl. Merdeka No. 123, Kelurahan Sukamaju, Kecamatan Cilandak, Jakarta Selatan',
            'telepon' => '08123456789',
            'email' => 'warungsederhana@gmail.com',
            'deskripsi' => 'Warung makan tradisional dengan berbagai menu masakan Indonesia yang lezat dan harga terjangkau.',
            'is_active' => true,
        ]);

        // Create Products for UMKM 1
        $products1 = [
            ['nama' => 'Nasi Goreng Spesial', 'deskripsi' => 'Nasi goreng dengan telur, ayam, dan sayuran segar', 'harga' => 25000, 'stok' => 50],
            ['nama' => 'Mie Ayam Komplit', 'deskripsi' => 'Mie ayam dengan topping lengkap dan pangsit', 'harga' => 20000, 'stok' => 30],
            ['nama' => 'Soto Ayam', 'deskripsi' => 'Soto ayam khas Jawa dengan kuah kuning', 'harga' => 18000, 'stok' => 40],
        ];

        foreach ($products1 as $product) {
            $p = Product::create([
                'umkm_id' => $umkm1->id,
                'nama' => $product['nama'],
                'deskripsi' => $product['deskripsi'],
                'harga' => $product['harga'],
                'stok' => $product['stok'],
                'is_active' => true,
            ]);
            $p->categories()->attach([1]); // Makanan category
        }

        // Create UMKM Owner 2
        $owner2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@umkm.test',
            'password' => Hash::make('password'),
            'role' => 'umkm_owner',
        ]);

        $umkm2 = Umkm::create([
            'user_id' => $owner2->id,
            'nama' => 'Batik Nusantara',
            'alamat' => 'Jl. Pasar Baru No. 45, Kelurahan Tanah Abang, Jakarta Pusat',
            'telepon' => '08567891234',
            'email' => 'batiknusantara@gmail.com',
            'deskripsi' => 'Menyediakan berbagai pilihan batik tulis dan batik cap dengan motif tradisional dan modern.',
            'is_active' => true,
        ]);

        // Create Products for UMKM 2
        $products2 = [
            ['nama' => 'Batik Tulis Solo', 'deskripsi' => 'Batik tulis asli Solo dengan motif parang', 'harga' => 350000, 'stok' => 15],
            ['nama' => 'Kemeja Batik Pria', 'deskripsi' => 'Kemeja batik lengan panjang untuk pria', 'harga' => 175000, 'stok' => 25],
            ['nama' => 'Kain Batik Pekalongan', 'deskripsi' => 'Kain batik cap motif Pekalongan', 'harga' => 85000, 'stok' => 40],
        ];

        foreach ($products2 as $product) {
            $p = Product::create([
                'umkm_id' => $umkm2->id,
                'nama' => $product['nama'],
                'deskripsi' => $product['deskripsi'],
                'harga' => $product['harga'],
                'stok' => $product['stok'],
                'is_active' => true,
            ]);
            $p->categories()->attach([4]); // Fashion category
        }

        // Create UMKM Owner 3
        $owner3 = User::create([
            'name' => 'Ahmad Hidayat',
            'email' => 'ahmad@umkm.test',
            'password' => Hash::make('password'),
            'role' => 'umkm_owner',
        ]);

        $umkm3 = Umkm::create([
            'user_id' => $owner3->id,
            'nama' => 'Jamu Sehat Alami',
            'alamat' => 'Jl. Raya Bogor Km 25, Kelurahan Ciracas, Jakarta Timur',
            'telepon' => '08789123456',
            'email' => 'jamusehat@gmail.com',
            'deskripsi' => 'Produsen jamu tradisional dengan bahan-bahan alami berkualitas tinggi.',
            'is_active' => true,
        ]);

        // Create Products for UMKM 3
        $products3 = [
            ['nama' => 'Jamu Kunyit Asam', 'deskripsi' => 'Jamu kunyit asam segar untuk menjaga kesehatan', 'harga' => 15000, 'stok' => 100],
            ['nama' => 'Jamu Beras Kencur', 'deskripsi' => 'Jamu beras kencur untuk menambah nafsu makan', 'harga' => 12000, 'stok' => 80],
            ['nama' => 'Madu Murni', 'deskripsi' => 'Madu murni asli hutan', 'harga' => 75000, 'stok' => 30],
        ];

        foreach ($products3 as $product) {
            $p = Product::create([
                'umkm_id' => $umkm3->id,
                'nama' => $product['nama'],
                'deskripsi' => $product['deskripsi'],
                'harga' => $product['harga'],
                'stok' => $product['stok'],
                'is_active' => true,
            ]);
            $p->categories()->attach([2, 6]); // Minuman & Herbal categories
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Admin Login:');
        $this->command->info('Email: admin@umkm.test');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('UMKM Owner Login:');
        $this->command->info('Email: owner@umkm.test');
        $this->command->info('Password: password');
    }
}
