<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(\App\Year::class, function (Faker $faker) {
    return [
        'year' => Carbon::now()->year,
        'start_date' => Carbon::parse('first Sunday of July')->toDateString(),
        'start_open' => Carbon::parse('first day of February')->toDateString(),
        'is_current' => '1'
    ];
});
