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
           'destinations' => ['wrocław', 'katowice', 'kraków', 'łódź']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'wadowice',
            'destinations' => ['wisła', 'kraków']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'łódź',
            'destinations' => ['wrocław', 'warszawa', 'kraków', 'gdańsk']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'kraków',
            'destinations' => ['wadowice', 'warszawa', 'katowice']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'wrocław',
            'destinations' => ['katowice', 'poznań']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'wisła',
            'destinations' => ['wadowice']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'warszawa',
            'destinations' => ['łódź', 'kraków', 'rzeszów']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'katowice',
            'destinations' => ['poznań', 'wrocław', 'kraków', 'warszawa']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'gdańsk',
            'destinations' => ['łódź']
        ]);

        factory(\App\Station::class)->create([
            'name' => 'rzeszów',
            'destinations' => []
        ]);
    }
}
