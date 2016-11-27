<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    public function roomid()
    {
        return $this->hasOne(Room::class);
    }

    public function timeslot()
    {
        return $this->hasOne(Timeslot::class);
    }
}
