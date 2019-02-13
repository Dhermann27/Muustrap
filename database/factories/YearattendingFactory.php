<?php

$factory->define(\App\Yearattending::class, function () {
    return [
        'days' => 6,
        'programid' => function () {
            return factory(\App\Program::class)->create()->id;
        }
    ];
});
