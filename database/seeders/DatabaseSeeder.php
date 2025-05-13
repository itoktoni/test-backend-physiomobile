<?php

namespace Database\Seeders;

use App\GenderEnum;
use App\IdTypeEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach(range(1, 10) as $index)
        {
            User::factory()->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'id_type' => fake()->randomElement(IdTypeEnum::cases())->value,
                'id_no' => Str::of(Str::random(10))->upper(),
                'gender' => fake()->randomElement(GenderEnum::cases())->value,
                'dob' => fake()->date(),
                'address' => fake()->address(),
            ]);
        }
    }
}
