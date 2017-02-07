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
        return $this->belongsTo(Timeslot::class);
    }

    public function getDisplayDaysAttribute()
    {
        $days = "";
        if ($this->m == '1') $days .= 'M';
        if ($this->t == '1') $days .= 'Tu';
        if ($this->w == '1') $days .= 'W';
        if ($this->th == '1') $days .= 'Th';
        if ($this->f == '1') $days .= 'F';
        return $days;
    }
}
