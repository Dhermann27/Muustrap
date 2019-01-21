<?php

use Faker\Generator as Faker;

$factory->define(\App\Chargetype::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'is_shown' => 0,
        'is_deposited' => 1
    ];
});
