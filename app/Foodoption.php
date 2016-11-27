<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foodoption extends Model
{
    public $timestamps = false;

    public function camper()
    {
        return $this->belongsTo(Camper::class);
    }
}
