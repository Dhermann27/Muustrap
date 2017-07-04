<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    public $timestamps = false;
    protected $primaryKey = "year";

    public function rates($year)
    {
        return \App\Rate::where('start_year', '<=', $this->year)->where('end_year', '>=', $this->year)->get();
    }

    public function getFirstDayAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->start_date, 'America/Chicago')->format('l F jS');
    }

    public function getLastDayAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->start_date, 'America/Chicago')->addDays(6)->format('l F jS');
    }

    public function getNextDayAttribute()
    {
        return Carbon::now()->max(Carbon::createFromFormat('Y-m-d', $this->start_date, 'America/Chicago'));
    }

    public function getNextWeekdayAttribute()
    {
        return Carbon::now()->max(Carbon::createFromFormat('Y-m-d', $this->start_date, 'America/Chicago')->addDay());
    }
}
