<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = "families";
    protected $fillable = ['name', 'address1', 'address2', 'city', 'statecd', 'zipcd', 'country',
        'is_address_current', 'is_address_current', 'is_scholar', 'is_ecomm'];

    public function campers()
    {
        return $this->hasMany(Camper::class, 'familyid', 'id');
    }

    public function statecode()
    {
        return $this->hasOne(Statecode::class, 'code', 'statecd');
    }
}
