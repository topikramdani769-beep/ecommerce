<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // MENGGUNAKAN firstOrCreate UNTUK MENGHINDARI DUPLIKAT
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Pencarian berdasarkan email
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('password'), // Pastikan password didefinisikan
            ]
        );
        $this->command->info('✅ Admin user handled: admin@example.com');

        // Gunakan count() agar lebih efisien atau cek apakah sudah ada data
        if (User::where('role', 'customer')->count() === 0) {
            User::factory(10)->create(['role' => 'customer']);
            $this->command->info('✅ 10 customer users created');
        }

        $this->call(CategorySeeder::class);

        // Jika tidak ingin produk terus bertambah setiap seed, tambahkan pengecekan count()
        if (Product::count() === 0) {
            Product::factory(50)->create();
            $this->command->info('✅ 50 products created');

            Product::factory(8)->featured()->create();
            $this->command->info('✅ 8 featured products created');
        }

        $this->command->newLine();
        $this->command->info('📧 Database seeding completed!');
        $this->command->info('📬 Admin login: admin@example.com / password');
    }
}