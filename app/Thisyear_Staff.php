<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thisyear_Staff extends Model
{
    protected $table = "thisyear_staff";

    public function camper()
    {
        return $this->hasOne(Camper::class, 'id', 'camperid');
    }

    public function family()
    {
        return $this->hasOne(Family::class, 'id', 'familyid');
    }

    public function program()
    {
        return $this->hasOne(Program::class, 'id', 'programid');
    }

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }
}
