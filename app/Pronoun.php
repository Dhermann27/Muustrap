<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pronoun extends Model
{
    public $timestamps = false;

    public function camper()
    {
        return $this->belongsTo(Camper::class);
    }
}
