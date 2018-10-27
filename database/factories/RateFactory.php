<?php

use Faker\Generator as Faker;

$factory->define(App\Rate::class, function (Faker $faker) {
    return [
        'buildingid' => $faker->randomNumber(),
        'programid' => $faker->randomNumber(),
        'min_occupancy' => 1,
        'max_occupancy' => 999,
        'rate' => $faker->randomFloat(2, 0, 1000 ),
        'start_year' => 1901,
        'end_year' => 2100
    ];
});
