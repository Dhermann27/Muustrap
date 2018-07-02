<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    public $timestamps = false;

    protected $dates = ['start_time', 'end_time'];

    public function workshops()
    {
        $year = \App\Year::where('is_current', '1')->first();
        return $this->hasMany(Workshop::class, 'timeslotid', 'id')
            ->where('year', $year->is_live ? $year->year : $year->year - 1);
    }

    public function newworkshops()
    {
        return $this->hasMany(Workshop::class, 'timeslotid', 'id')
            ->where('year', \App\Year::where('is_current', '1')->first()->year);
    }
}
