<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Year extends Model
{
    public $timestamps = false;
    protected $primaryKey = "year";

    public function rates()
    {
        return DB::table('rates')->join('programs', 'programs.id', 'rates.programid')->where('start_year', '<=', $this->year)->where('end_year', '>', $this->year)
            ->whereIn('buildingid', ['1000', '1007', '1017'])->orderBy('name')->orderBy('min_occupancy')
            ->orderBy('max_occupancy');
    }

    public function isInProgress()
    {
        return Carbon::now('America/Chicago')->lte(Carbon::createFromFormat('Y-m-d', $this->start_date)->addWeek());
    }

    public function isLive()
    {
        return Storage::disk('local')->exists('public/MUUSA_' . $this->year . '_Brochure.pdf');
    }

    public function isCrunch()
    {
        return Carbon::now('America/Chicago')->lte(Carbon::createFromFormat('Y-m-d', $this->start_date)->subWeeks(2));
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

    public function getNextMuseAttribute()
    {
        $now = Carbon::now('America/Chicago');
        if (Storage::disk('local')->exists('public/muses/' . $now->format('Ymd') . '.pdf')) {
            return "Today's Muse";
        } elseif (Storage::disk('local')->exists('public/muses/' . $now->subDay()->format('Ymd') . '.pdf')) {
            return "Yesterday's Muse";
        } elseif (Storage::disk('local')->exists('public/muses/' . $this->year . '0601.pdf')) {
            return "Pre-Camp Muse";
        } else {
            return false;
        }
    }
}
