<?php

use Faker\Generator as Faker;

$factory->define(App\Building::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'blurb' => $faker->paragraph
    ];
});
