<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar', ['campers' => $this->getCampers(),
            'year' => \App\Year::where('is_current', '1')->first()]);
    }

    private function getCampers()
    {
        return \App\Thisyear_Camper::where('familyid', \App\Thisyear_Camper::where('email', Auth::user()->email)->first()->familyid)->orderBy('birthdate')->get();
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}
