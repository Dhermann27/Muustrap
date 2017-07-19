<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thisyear_Family extends Model
{
    protected $table = "thisyear_families";

    public function campers()
    {
        return $this->hasMany(Thisyear_Camper::class, 'familyid', 'id')
            ->orderBy('birthdate');
    }

    public function charges()
    {
        return $this->hasMany(Thisyear_Charge::class, 'familyid', 'id');
    }

    public function getFamilyNameAttribute()
    {
        if ($this->count > 1) {
            return 'The ' . $this->name . ' Family';
        } else {
            $camper = \App\Thisyear_Camper::where('familyid', $this->id)->first();
            return $camper->firstname . ' ' . $camper->lastname;
        }
    }

    public function getStateCodeAttribute()
    {
        return $this->statecd == '__' ? $this->country : $this->statecd;
    }
}
