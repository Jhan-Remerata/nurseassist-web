<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed users
        User::create([
            'name' => 'Jhon Remerata',
            'email' => 'jhon@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Rachel Gomez',
            'email' => 'rachel@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // Call patient seeder
        $this->call(PatientSeeder::class);
    }
}
