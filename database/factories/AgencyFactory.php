<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agency>
 */
class AgencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nev' => $this->faker->company,
            'cim' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'telefon' => $this->faker->phoneNumber,
        ];
    }
}
