<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan UserSeeder untuk menambahkan user
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(VehicleSeeder::class);

        
        // Jika ingin menambahkan factory atau seeder lainnya, bisa di sini
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
