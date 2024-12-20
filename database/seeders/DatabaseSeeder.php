<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nombres' => 'Test',
            'apellido_paterno' => 'User',
            'apellido_materno' => 'Example',
            'telefono' => '1234567890',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'rol' => 'arrendador',
        ]);
        
    }
}
