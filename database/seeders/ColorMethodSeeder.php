<?php

namespace Database\Seeders;

use App\Models\ColorMethod;
use Illuminate\Database\Seeder;

class ColorMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ColorMethod::factory(10)->create();
    }
}
