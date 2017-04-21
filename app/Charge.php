<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = ['camperid', 'amount', 'memo', 'chargetypeid', 'year', 'deposited_date', 'timestamp'];

    public function camper()
    {
        return $this->hasOne(Camper::class, 'id', 'camperid');
    }

    public function chargetype()
    {
        return $this->hasOne(Chargetype::class, 'id', 'chargetypeid');
    }
}
