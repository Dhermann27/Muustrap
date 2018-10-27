<?php

use Faker\Generator as Faker;

$factory->define(App\Program::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(4),
        'name' => $faker->name,
        'blurb' => implode(' ', $faker->words(30)),
        'is_program_housing' => 0
    ];
});
