<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WelcomeController extends Controller
{
    public function index()
    {
        $year = \App\Year::where('is_current', '1')->first();
        $muse = Storage::disk('local')->exists('public/muses/' . $year->next_day->format('Ymd') . '.pdf');
        if ($year->isCrunch()) {
            return $this->normal($muse);
        } else {
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', env('GOOGLE_CAL_SCRIPT') . env('COFFEEHOUSE_CALENDAR') . "&date=" . $year->next_weekday->toDateString());
            $av = false;
            $camper = null;
            if (Auth::check()) {
                $camper = \App\Thisyear_Camper::where('email', Auth::user()->email)->first();
                if (isset($camper)) {
                    foreach ($camper->yearattending->positions as $position) {
                        if ($position->staffpositionid == '1117' || $position->staffpositionid == '1103') {
                            $av = true;
                        }
                    }
                }
            }
            return view('crunch', ['muse' => $muse, 'av' => $av, 'camper' => $camper,
                'list' => json_decode($res->getBody())]);
        }
    }

    public function normal($muse)
    {
        if (Auth::check()) {
            $camper = \App\Camper::where('email', Auth::user()->email)->first();
            if ($camper !== null) {
                $family = \App\Thisyear_Family::find($camper->family->id);
                $yas = DB::table('thisyear_campers')->where('familyid', $camper->family->id)->pluck('yearattendingid');
                $paid = $this->isPaid($family);
                $signedup = $paid && $this->isSignedup($yas);
                $roomid = $signedup && $this->isRoomAssigned($yas);
                $nametags = $roomid && $this->isNametagsCreated($yas);
                $confirmed = $nametags && $this->isConfirmed($family);
                return view('welcome', ['family' => $family, 'paid' => $paid, 'signedup' => $signedup,
                    'nametags' => $nametags, 'roomid' => $roomid, 'confirmed' => $confirmed, 'muse' => $muse]);

            }
        }
        return view('welcome', ['registered' => '0']);
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

}
