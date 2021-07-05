<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MissionLine;

class MissionLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MissionLine::factory(100)->create();
    }
}
