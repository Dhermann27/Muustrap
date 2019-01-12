<?php

use Faker\Generator as Faker;

$factory->define(\App\Camper::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->safeEmail,
        'phonenbr' => $faker->phoneNumber,
        'birthdate' => $faker->dateTimeBetween('-100 years', '-19 years'),
        'roommate' => $faker->name,
        'sponsor' => $faker->name,
        'foodoptionid' => function () {
            return factory(\App\Foodoption::class)->create()->id;
        },
        'churchid' => function () {
            return factory(\App\Church::class)->create()->id;
        }
    ];
});
