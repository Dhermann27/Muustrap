<?php

namespace App;

use Carbon\Carbon;
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
        return $this->hasOne(Timeslot::class, 'id', 'timeslotid');
    }

    public function choices()
    {
        return $this->hasMany(Yearattending__Workshop::class, 'workshopid', 'id');
    }

    public function days($year)
    {
        $days = array();
        $start = new Carbon($year->start_date . ' ' . explode(' ', $this->timeslot->start_time)[1], 'America/Vancouver');
        $end = new Carbon($year->start_date . ' ' . explode(' ', $this->timeslot->end_time)[1], 'America/Vancouver');
        for ($i = 0; $i < 5; $i++) {
            $start->addDay();
            $end->addDay();
            if ($i == 0 && $this->m == '1') array_push($days, [$start->toDateTimeString(), $end->toDateTimeString()]);
            if ($i == 1 && $this->t == '1') array_push($days, [$start->toDateTimeString(), $end->toDateTimeString()]);
            if ($i == 2 && $this->w == '1') array_push($days, [$start->toDateTimeString(), $end->toDateTimeString()]);
            if ($i == 3 && $this->th == '1') array_push($days, [$start->toDateTimeString(), $end->toDateTimeString()]);
            if ($i == 4 && $this->f == '1') array_push($days, [$start->toDateTimeString(), $end->toDateTimeString()]);
        }
        return $days;
    }

    public function getBitDaysAttribute() {
        return $this->m . $this->t . $this->w . $this->th . $this->f;
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

    public function getEmailsAttribute()
    {
        return DB::table('yearattending__workshop')
            ->join('yearsattending', 'yearsattending.id', '=', 'yearattending__workshop.yearattendingid')
            ->join('campers', 'campers.id', '=', 'yearsattending.camperid')
            ->where('yearattending__workshop.workshopid', $this->id)->where('campers.email', '!=', null)
            ->implode('email', '; ');
    }
}
