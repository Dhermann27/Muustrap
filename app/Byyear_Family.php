<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byyear_Family extends Model
{
    protected $table = "byyear_families";

    public function campers()
    {
        return $this->hasMany(Byyear_Camper::class, 'familyid', 'id');
    }
}
