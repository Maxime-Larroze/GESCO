<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'source_type' => $this->faker->randomDigit(),
            'source_id' => \App\Models\Organisation::pluck('id')->random(),
            'price' => $this->faker->randomDigit(),
        ];
    }
}
