<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Workshop extends Model
{
    public function room()
    {
        return $this->hasOne(Room::class, 'id', 'roomid');
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function choices() {
        return $this->hasMany(Yearattending__Workshop::class, 'workshopid', 'id');
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

    public function getEmailsAttribute() {
        return DB::table('yearattending__workshop')
            ->join('yearsattending', 'yearsattending.id', '=', 'yearattending__workshop.yearattendingid')
            ->join('campers', 'campers.id', '=', 'yearsattending.camperid')
            ->where('yearattending__workshop.workshopid', $this->id)->where('campers.email', '!=', null)
            ->implode('email', '; ');
    }
}
