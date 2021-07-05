<?php

namespace Database\Factories;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganisationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organisation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->unique()->phoneNumber(),
            'address' => $this->faker->unique()->address(),
            'type' => $this->faker->randomElement(["school", "organisation", "government"]),
        ];
    }
}
