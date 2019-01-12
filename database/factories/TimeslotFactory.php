<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Timeslot::class, function (Faker $faker) {
    $datetime = Carbon::now()->setTimestamp($faker->dateTimeThisYear->getTimestamp());
    return [
        'name' => $faker->company,
        'code' => $faker->stateAbbr,
        'start_time' => $datetime->toDateTimeString(),
        'end_time' => $datetime->addMinutes(rand(15, 300))->toDateTimeString()
    ];
});