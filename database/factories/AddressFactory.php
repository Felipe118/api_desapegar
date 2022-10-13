<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'district' => $this->faker->secondaryAddress,
            'cep' => $this->faker->postcode,
            'street' => $this->faker->streetAddress,
            'number' => $this->faker->randomNumber(),
            'user_id' => User::factory(),

        ];
    }
}
