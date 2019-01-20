<?php

use Faker\Generator as Faker;

$factory->define(\App\Church::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'city' => $faker->city,
        'statecd' => function () {
            return factory(\App\Statecode::class)->create()->id;
        }
    ];
});
