<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thisyear_Camper extends Model
{
    protected $table = "thisyear_campers";

    public function church()
    {
        return $this->hasOne(Church::class, 'id', 'churchid');
    }

    public function foodoption()
    {
        return $this->hasOne(Foodoption::class, 'id', 'foodoptionid');
    }

    public function pronoun()
    {
        return $this->hasOne(Pronoun::class, 'id', 'pronounid');
    }

    public function yearattending() {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }
}
