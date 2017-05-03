<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thisyear_Charge extends Model
{
    protected $table = "thisyear_charges";

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
