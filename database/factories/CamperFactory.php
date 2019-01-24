<?php

use Faker\Generator as Faker;

$factory->define(\App\Camper::class, function (Faker $faker) {
    $year = date("Y") - \App\Year::where('is_current', '1')->first()->year;
    return [
        'pronounid' => function () {
            return factory(\App\Pronoun::class)->create()->id;
        },
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->safeEmail,
        'phonenbr' => $faker->regexify('[1-9]\d{9}'),
        'birthdate' => $faker->dateTimeBetween('-' . (100+$year) . ' years', '-' . (19+$year) . ' years')->format('Y-m-d'),
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
