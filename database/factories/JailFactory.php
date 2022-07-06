<?php

namespace Database\Factories;

use App\Models\Jail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jail>
 */
class JailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Jail::class;

    public function definition()
    {
        return [

            'name' => $this->faker->streetName,
            'code' => $this->faker->iban(),
            'type' => $this->faker->randomElement(['low', 'medium', 'high']),
            'capacity' => $this->faker->numberBetween($min = 4, $max = 8),
            'description' => $this->faker->text(255),
        ];
    }


}

