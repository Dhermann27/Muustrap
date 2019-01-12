<?php

use Faker\Generator as Faker;

$factory->define(\App\Statecode::class, function (Faker $faker) {
    return [
        'id' => $faker->randomLetter . $faker->randomLetter, //$faker->unique()->stateAbbr,
        'name' => $faker->state
    ];
});
