<?php

use Faker\Generator as Faker;

$factory->define(App\Program::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'display' => $faker->sentence,
        'blurb' => $faker->paragraph,
        'letter' => implode('<br />', $faker->paragraphs),
        'covenant' => $faker->paragraph,
        'is_program_housing' => 0
    ];
});
