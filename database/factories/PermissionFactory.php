<?php

use Faker\Generator as Faker;

$factory->define(\App\Permission::class, function (Faker $faker) {
    return [
        'display_name' => $faker->title,
        'description' => $faker->sentence
    ];
});
