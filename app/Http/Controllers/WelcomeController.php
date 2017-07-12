<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $year = \App\Year::where('is_current', '1')->first();
        if (Carbon::now('America/Chicago')->lte(Carbon::createFromFormat('Y-m-d', $year->start_date)->subWeeks(2))) {
            return $this->normal($year);
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
            return view('crunch', ['muse' => true, 'av' => $av, 'camper' => $camper,
                'day' => $year->next_weekday->format('l F jS'), 'list' => json_decode($res->getBody())]);
        }
    }

    public function normal($year)
    {
        $payload = ['updatedFamily' => '0', 'updatedCamper' => 0, 'registered' => 0, 'paid' => 0];
        if (Auth::check()) {
            $open = new \DateTime(\App\Year::where('year', DB::raw('getcurrentyear()-1'))->first()->start_date);
            $camper = \App\Camper::where('email', Auth::user()->email)->first();
            if ($camper !== null) {

                $family = \App\Thisyear_Family::find($camper->family->id);
                $payload['registered'] = $this->isRegistered($family);
                $payload['paid'] = $this->isPaid($family);
                $payload['signedup'] = $this->isSignedup($family);
                $payload['roomid'] = \App\Thisyear_Camper::where('id', $camper->id)->first();
            }
        }

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
        $payload['muse'] = true;
        $payload['av'] = $av;
        $payload['day'] = $year->next_weekday->format('l F jS');
        $payload['list'] = json_decode($res->getBody());


        return view('welcome', $payload);
    }

    private
    function isRegistered($family)
    {
        return $family != null && $family->count > 0;
    }

    private
    function isPaid($family)
    {
        return $family != null &&
            \App\Thisyear_Charge::where('familyid', $family->id)->where('chargetypeid', 1003)->
            where('chargetypeid', 1003)->orWhere('amount', '<', '0')->get()->sum('amount') > 0;
    }

    private
    function isSignedup($family)
    {
        if ($family != null) {
            return DB::table('thisyear_campers')->where('familyid', $family->id)
                ->join('yearsattending', 'yearsattending.camperid', '=', 'thisyear_campers.id')
                ->join('yearattending__workshop', 'yearattending__workshop.yearattendingid', '=', 'yearsattending.id')
                ->count();
        } else {
            return 0;
        }
    }

}
