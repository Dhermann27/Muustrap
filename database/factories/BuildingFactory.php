<?php

use Faker\Generator as Faker;

$factory->define(App\Building::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'name' => $faker->name,
        'blurb' => implode(' ', $faker->words(30))
    ];
});
