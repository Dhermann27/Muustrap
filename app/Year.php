<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Year extends Model
{
    public $timestamps = false;
    protected $primaryKey = "year";

    public function rates($year)
    {
        return \App\Rate::where('start_year', '<=', $this->year)->where('end_year', '>=', $this->year)->get();
    }

    public function isLive()
    {
        return Storage::disk('local')->exists('public/MUUSA_' . $this->year . '_Brochure.pdf');
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
        $lastfirst = Carbon::createFromFormat('Y-m-d', \App\Year::where('year', $this->year - 1)->first()->start_date, 'America/Chicago');
        $now = Carbon::now('America/Chicago');
        if ($now->between($lastfirst, $lastfirst->addDays(7))) {
            return $now;
        }
        return $now->max(Carbon::createFromFormat('Y-m-d', $this->start_date, 'America/Chicago'));
    }
}
