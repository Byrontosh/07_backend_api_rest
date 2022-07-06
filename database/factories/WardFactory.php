<?php

namespace Database\Factories;

use App\Models\Ward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ward>
 */
class WardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ward::class;

    public function definition()
    {
        return [
            'name' => $this->faker->streetName,
            'location' => $this->faker->streetName,
            'description' => $this->faker->text($maxNbChars = 45),
        ];
    }


}
