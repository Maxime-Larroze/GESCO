<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contribution;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contribution::factory(100)->create();
    }
}
