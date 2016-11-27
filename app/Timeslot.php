<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    public $timestamps = false;

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
