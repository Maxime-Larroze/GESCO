<?php

namespace Database\Factories;

use App\Models\MissionLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MissionLineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MissionLine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'mission_id' => \App\Models\Mission::pluck('id')->random(),
            'title' => $this->faker->sentence,
            'quantity' => $this->faker->randomDigit(),
            'price' => $this->faker->randomDigit(),
            'unity' => $this->faker->sentence,
        ];
    }
}
