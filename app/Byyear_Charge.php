<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byyear_Charge extends Model
{
    protected $table = "byyear_charges";

    public function family()
    {
        return $this->hasOne(Family::class);
    }

    public function camper()
    {
        return $this->hasOne(Camper::class);
    }

    public function chargetype()
    {
        return $this->hasOne(Chargetype::class);
    }
}
