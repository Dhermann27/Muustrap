<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = ['camperid', 'chargetypeid', 'year'];

    public function camper()
    {
        return $this->hasOne(Camper::class);
    }

    public function chargetype()
    {
        return $this->hasOne(Chargetype::class);
    }
}
