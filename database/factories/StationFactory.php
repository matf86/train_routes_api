<?php

use Faker\Generator as Faker;

$factory->define(\App\Station::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'destinations' => []
    ];
});
