<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $payload = ['updatedFamily' => '0', 'updatedCamper' => 0, 'registered' => 0, 'paid' => 0];
        $payload['year'] = \App\Year::where('is_current', '1')->first();
        if (Auth::check()) {
            $open = new \DateTime(\App\Year::where('year', DB::raw('getcurrentyear()-1'))->first()->start_date);
            $camper = \App\Camper::where('email', Auth::user()->email)->first();
            if ($camper !== null) {
                $payload['updatedFamily'] = $this->isFamilyUpdated($camper, $open);
                $payload['updatedCamper'] = $this->isCamperUpdated($camper, $open);

                $family = \App\Thisyear_Family::find($camper->family->id);
                $payload['registered'] = $this->isRegistered($family);
                $payload['paid'] = $this->isPaid($family);
                $payload['signedup'] = $this->isSignedup($family);
                $payload['roomid'] = \App\Thisyear_Camper::where('id', $camper->id)->first();
            }
        }
        return view('welcome', $payload);
    }

    private function isFamilyUpdated($camper, $open)
    {
        return $camper->family->updated_at !== null ? new \DateTime($camper->family->updated_at) > $open : 0;
    }

    private function isCamperUpdated($camper, $open)
    {
        return $camper->updated_at !== null ? new \DateTime($camper->updated_at) > $open : 0;
    }

    private function isRegistered($family)
    {
        return $family != null && $family->count > 0;
    }

    private function isPaid($family)
    {
        return $family != null &&
            \App\Thisyear_Charge::where('familyid', $family->id)->where('chargetypeid', 1003)->
            where('chargetypeid', 1003)->orWhere('amount', '<', '0')->get()->sum('amount') <= 0;
    }

    private function isSignedup($family) {
        if($family != null) {
            return DB::table('thisyear_campers')->where('familyid', $family->id)
                ->join('yearsattending', 'yearsattending.camperid', '=', 'thisyear_campers.id')
                ->join('yearattending__workshop', 'yearattending__workshop.yearattendingid', '=', 'yearsattending.id')
                ->count();
        } else {
            return 0;
        }
    }

}
