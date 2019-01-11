<?php

use Faker\Generator as Faker;

$factory->define(App\Timeslot::class, function (Faker $faker) {
   return [
       'name' => $faker->company,
       'code' => $faker->stateAbbr,
       'start_time' => $faker->dateTimeThisYear,
       'end_time' => $faker->dateTimeThisYear
   ] ;
});