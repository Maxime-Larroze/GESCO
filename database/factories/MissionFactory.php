<?php

namespace Database\Factories;

use App\Models\Mission;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'reference' => $this->faker->slug(),
            'organisation_id' => \App\Models\Organisation::pluck('id')->random(),
            'title' => $this->faker->sentence,
            'comment' => $this->faker->paragraph(1),
            'deposit' => $this->faker->randomDigit(),
            'ended_at' => now(),
        ];
    }
}
