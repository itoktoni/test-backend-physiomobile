<?php

namespace Database\Seeders;

<<<<<<< HEAD
=======
use App\MediumAcquisitionEnum;
>>>>>>> 234361882c0f55fa7895455d5e20ff3a257f89af
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Patient::create([
                'user_id' => $user->id,
                'medium_acquisition' => fake()->randomElement(MediumAcquisitionEnum::cases())->value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
