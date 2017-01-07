<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camper extends Model
{
    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }

    public function church()
    {
        return $this->hasOne(Church::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'familyid');
    }

    public function gencharge()
    {
        return $this->belongsTo(Gencharge::class);
    }

    public function foodoption()
    {
        return $this->hasOne(Foodoption::class);
    }

    public function oldgencharge()
    {
        return $this->belongsTo(Oldgencharge::class);
    }

    public function yearattending()
    {
        return $this->belongsTo(Yearattending::class);
    }

}
