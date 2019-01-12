<?php

use Faker\Generator as Faker;

$factory->define(\App\Foodoption::class, function (Faker $faker) {
    return [
        'name' => $faker->title
    ];
});
