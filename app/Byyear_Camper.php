<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byyear_Camper extends Model
{
    protected $table = "byyear_campers";

    public function church()
    {
        return $this->hasOne(Church::class, 'id', 'churchid');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'familyid');
    }

    public function foodoption()
    {
        return $this->hasOne(Foodoption::class, 'id', 'foodoptionid');
    }

    public function pronoun()
    {
        return $this->hasOne(Pronoun::class, 'id', 'pronounid');
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'id', 'roomid');
    }

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }
}
