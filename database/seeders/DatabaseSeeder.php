<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pasien 1',
            'email' => 'pasien1@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'pasien',
        ]);

        User::create([
            'name' => 'Pasien 2',
            'email' => 'pasien2@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'pasien',
        ]);

        User::create([
            'name' => 'Dokter 1',
            'email' => 'dokter1@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'dokter',
        ]);

        User::create([
            'name' => 'Dokter 2',
            'email' => 'dokter2@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'dokter',
        ]);

        User::create([
            'name' => 'Apoteker 1',
            'email' => 'apoteker1@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'apoteker',
        ]);

        User::create([
            'name' => 'Apoteker 2',
            'email' => 'apoteker2@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'apoteker',
        ]);

        User::factory(30)->create();

        Medicine::factory(30)->create();
    }
}
