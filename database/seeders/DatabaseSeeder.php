<?php

namespace Database\Seeders;

use App\Models\ColorMethod;
use App\Models\ColorNameMethod;
use App\Models\Style;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect([ // colorMethodSeeds
            ['name' => "Roasted",'desc' => "Pengolahan warna dengan dibakar"],
            ['name' => "Boiled",'desc' => "Pengolahan warna dengan di rebus"],
            ['name' => "Printed",'desc' => "Pengolahan warna dengan di print"],
        ])->each(function($seed){ColorMethod::create($seed);});

        collect([ // styleSeeds
            ['name' => "Hair Punk",'desc' => "Week Style Kekinian"],
            ['name' => "Yellow Rainbow",'desc' => "Week Style Kidz Zaman Now"],
            ['name' => "Relic Style",'desc' => "Week Style Classic"],
        ])->each(function($seed){Style::create($seed);});

        collect([ // colorNameMethodSeeds
            ['name'=>"Red Classic",'method_id'=>ColorMethod::where('name',"Roasted")->first()->id],
            ['name'=>"Blue Marin",'method_id'=>ColorMethod::where('name',"Roasted")->first()->id],
            ['name'=>"Dark Morron",'method_id'=>ColorMethod::where('name',"Boiled")->first()->id],
            ['name'=>"Grey Water",'method_id'=>ColorMethod::where('name',"Printed")->first()->id],
        ])->each(function($seed){ColorNameMethod::create($seed);});

        $this->call([
            ColorMethodSeeder::class,
            StyleSeeder::class,
        ]);
    }
}
