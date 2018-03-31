<?php

use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Station::class)->create([
           'name' => 'poznań',
           'destinations' => ['wrocław', 'katowice', 'kraków']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'wadowice',
            'destinations' => ['wisła']
        ]);


        factory(\App\Station::class)->create([
            'name' => 'łódź',
            'destinations' => ['wrocław', 'warszawa', 'kraków', 'gdańsk']
        ]);
    }
}
