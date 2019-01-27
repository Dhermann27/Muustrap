<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Church extends Model
{
    use SearchableTrait;

    protected $table = "churches";

    protected $searchable = [
        'columns' => [
            'churches.name' => 10,
            'churches.city' => 10,
            'churches.statecd' => 2,
            'statecodes.name' => 5
        ],
        'joins' => [
            'statecodes' => ['churches.statecd', 'statecodes.id']
        ]
    ];

    public function camper()
    {
        return $this->belongsTo(Camper::class);
    }

    public function statecode()
    {
        return $this->hasOne(Statecode::class, 'id', 'statecd');
    }
}
