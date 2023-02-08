<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'PAAL',
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
