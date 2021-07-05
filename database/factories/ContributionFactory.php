<?php

namespace Database\Factories;

use App\Models\Contribution;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContributionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contribution::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'price' => $this->faker->randomDigit(),
            'title' => $this->faker->sentence,
            'comment' => $this->faker->paragraph(1),
            'organisation_id' => \App\Models\Organisation::pluck('id')->random(),
        ];
    }
}
