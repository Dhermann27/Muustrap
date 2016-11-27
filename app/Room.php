<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function building()
    {
        return $this->hasOne(Building::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function yearattending()
    {
        return $this->belongsTo(Yearattending::class);
    }
}
