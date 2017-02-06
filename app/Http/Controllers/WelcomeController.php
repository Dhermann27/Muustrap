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

                $family = \App\Thisyear_Family::where('id', $camper->family->id)->first();
                $payload['registered'] = $this->isRegistered($family);
                $payload['paid'] = $this->isPaid($family);
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
        return $family != null && $family->paydate != null;
    }

}
