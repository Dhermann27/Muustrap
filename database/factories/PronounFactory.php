<?php

use Faker\Generator as Faker;

$factory->define(\App\Pronoun::class, function (Faker $faker) {
    return [
        'code' => $faker->randomLetter,
        'name' => $faker->word
    ];
});
