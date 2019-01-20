<?php

use Faker\Generator as Faker;

$factory->define(\App\Camper::class, function (Faker $faker) {
    return [
        'pronounid' => function () {
            return factory(\App\Pronoun::class)->create()->id;
        },
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->safeEmail,
        'phonenbr' => $faker->regexify('\d{3}-\d{3}-\d{4}'),
        'birthdate' => $faker->dateTimeBetween('-100 years', '-19 years')->format('Y-m-d'),
        'roommate' => $faker->name,
        'sponsor' => $faker->name,
        'churchid' => function () {
            return factory(\App\Church::class)->create()->id;
        },
        'is_handicap' => rand(0, 1),
        'foodoptionid' => function () {
            return factory(\App\Foodoption::class)->create()->id;
        }
    ];
});
