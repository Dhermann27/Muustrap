<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $year = $this->year;

        // Coffeehouse
        $nowyear = \App\Year::whereDate('start_date', '<', Carbon::today()->toDateString())
            ->whereDate('start_date', '>=', Carbon::today()->subDays(7)->toDateString())->first();
        if ($nowyear == null) $nowyear = $year;
        $av = false;
        $camper = null;
        if (Auth::check()) {
            $camper = \App\Byyear_Camper::where('year', $nowyear->year)->where('email', Auth::user()->email)->first();
            if (isset($camper)) {
                foreach ($camper->yearattending->positions as $position) {
                    if ($position->staffpositionid == '1117' || $position->staffpositionid == '1103') {
                        $av = true;
                    }
                }
            }
        }
        $onstage = \App\Coffeehouseact::where('date', $nowyear->next_weekday->toDateString())->where('is_onstage', '1')
            ->orderBy('order', 'desc')->first();
        $starttime = Carbon::now('America/Chicago');
        if ($onstage == null) {
            $starttime->hour(20)->minute(50);
        }
        $acts = \App\Coffeehouseact::where('date', $nowyear->next_weekday->toDateString())->where('is_onstage', '0')
            ->orderBy('order')->get();

        if ($year->is_crunch == 1) {
            return view('crunch', ['av' => $av, 'camper' => $camper, 'onstage' => $onstage,
                'starttime' => $starttime, 'actslist' => $acts]);
        } else {
            if (Auth::check()) {
                $camper = Auth::user()->camper;
                if ($camper !== null) {
                    $family = \App\Thisyear_Family::find($camper->family->id);
                    $yas = DB::table('thisyear_campers')->where('familyid', $camper->family->id)->pluck('yearattendingid');
                    $paid = $this->isPaid($family);
                    $signedup = $paid && $this->isSignedup($yas);
                    $roomid = $signedup && $this->isRoomAssigned($yas);
                    $nametags = $roomid && $this->isNametagsCreated($yas);
                    $confirmed = $nametags && $this->isConfirmed($family);
                    return view('welcome', ['family' => $family, 'paid' => $paid, 'signedup' => $signedup,
                        'nametags' => $nametags, 'roomid' => $roomid, 'confirmed' => $confirmed, 'av' => $av,
                        'camper' => $camper, 'onstage' => $onstage, 'starttime' => $starttime, 'actslist' => $acts]);

                }
            }
            return view('welcome', ['registered' => '0', 'av' => $av, 'camper' => $camper, 'onstage' => $onstage,
                'starttime' => $starttime, 'actslist' => $acts]);
        }
    }

    private function isPaid($family)
    {
        return $family != null &&
            \App\Thisyear_Charge::where('familyid', $family->id)
                ->where(function ($query) {
                    $query->where('chargetypeid', 1003)->orWhere('amount', '<', '0');
                })->sum('amount') <= 0.0;
    }

    private function isSignedup($yas)
    {
        return \App\Yearattending__Workshop::whereIn('yearattendingid', $yas)->count() > 0;
    }

    public function isRoomAssigned($yas)
    {
        return \App\Yearattending::whereIn('id', $yas)->whereNotNull('roomid')->count() > 0;
    }

    public function isNametagsCreated($yas)
    {
        $nametags = \App\Yearattending::whereIn('id', $yas)->groupBy('yearsattending.nametag')->get();
        return count($nametags) > 1 || (count($nametags) == 1 && $nametags->first()->nametag != '222215521');
    }

    public function isConfirmed($family)
    {
        $kids = DB::table('thisyear_campers')->where('familyid', $family->id)->where('age', '<', 18)->pluck('yearattendingid');
        return \App\Medicalresponse::whereIn('yearattendingid', $kids)->count() == count($kids);
    }

    public function campcost()
    {
        return view('campcost', ['rates' => DB::table('rates')
            ->join('years', function ($join) {
                $join->on('rates.start_year', '<=', 'years.year')->on('rates.end_year', '>', 'years.year');
            })->join('programs', 'programs.id', 'rates.programid')
            ->whereIn('buildingid', ['1000', '1007', '1017'])
            ->orderBy('name')->orderBy('min_occupancy')->orderBy('max_occupancy')->get()]);
    }

}
