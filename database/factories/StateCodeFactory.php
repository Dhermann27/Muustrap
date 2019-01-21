<?php

use Faker\Generator as Faker;

$factory->define(\App\Statecode::class, function (Faker $faker) {
    return [
        'id' => $faker->regexify('[A-Z]{4}'), //$faker->unique()->stateAbbr,
        'name' => $faker->state
    ];
});
