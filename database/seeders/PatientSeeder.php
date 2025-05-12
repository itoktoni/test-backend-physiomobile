<?php

namespace Database\Seeders;

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
        $mediums = ['website', 'referral', 'advertisement', 'social_media'];

        foreach ($users as $user) {
            Patient::create([
                'user_id' => $user->id,
                'medium_acquisition' => $mediums[array_rand($mediums)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
