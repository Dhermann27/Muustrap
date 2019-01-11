<?php

use Faker\Generator as Faker;

$factory->define(App\Program::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'blurb' => $faker->paragraph,
        'is_program_housing' => 0
    ];
});
