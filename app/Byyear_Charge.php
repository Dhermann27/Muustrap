<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byyear_Charge extends Model
{
    protected $table = "byyear_charges";

    public function family()
    {
        return $this->hasOne(Family::class, 'id', 'familyid');
    }

    public function camper()
    {
        return $this->hasOne(Camper::class, 'id', 'camperid');
    }

    public function chargetype()
    {
        return $this->hasOne(Chargetype::class, 'id', 'chargetypeid');
    }
}
