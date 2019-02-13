<?php

use Faker\Generator as Faker;

$factory->define(App\Rate::class, function (Faker $faker) {
    return [
        'min_occupancy' => 1,
        'max_occupancy' => 999,
        'rate' => $faker->randomFloat(2, 34, 500 ),
        'start_year' => 1901,
        'end_year' => 2100
    ];
});
