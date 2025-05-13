<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $user = UserFactory::new();

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'id_type' => 'identity_card',
            'id_no' => '1234567890',
            'gender' => 'male',
            'dob' => '1990-08-15',
            'medium_acquisition' => 'walk_in'
        ];
    }
}