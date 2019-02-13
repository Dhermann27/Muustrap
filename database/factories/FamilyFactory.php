<?php

use Faker\Generator as Faker;

$factory->define(\App\Family::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'address1' => $faker->streetAddress,
        'address2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'statecd' => function () {
            return factory(\App\Statecode::class)->create()->id;
        },
        'zipcd' => substr($faker->postcode, 0, 5),
        'country' => $faker->country,
        'is_address_current' => '1',
        'is_ecomm' => rand(0,1),
        'is_scholar' => rand(0,1)
    ];
});
