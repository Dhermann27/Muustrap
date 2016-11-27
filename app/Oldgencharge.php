<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oldgencharge extends Model
{
    public function camper()
    {
        return $this->hasOne(Camper::class);
    }

    public function chargetype()
    {
        return $this->hasOne(Chargetype::class);
    }
}
