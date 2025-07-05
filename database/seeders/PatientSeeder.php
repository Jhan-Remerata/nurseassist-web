<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = ['male', 'female'];
        $rooms = range(101, 120);

        for ($i = 1; $i <= 20; $i++) {
            $gender = $genders[array_rand($genders)];

            Patient::create([
                'name' => fake()->name($gender),
                'age' => rand(18, 90),
                'room_number' => $rooms[array_rand($rooms)],
                'gender' => $gender,
            ]);
        }
    }
}
