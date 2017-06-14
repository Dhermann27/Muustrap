<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function read($id) {
        return view('calendar', ['campers' => \App\Thisyear_Camper::where('familyid', \App\Thisyear_Camper::find($id)->familyid)->orderBy('birthdate')->get(),
            'year' => \App\Year::where('is_current', '1')->first()]);
    }

    public function index()
    {
        return view('calendar', ['campers' => $this->getCampers(),
            'year' => \App\Year::where('is_current', '1')->first()]);
    }

    private function getCampers()
    {
        return \App\Thisyear_Camper::where('familyid', \App\Thisyear_Camper::where('email', Auth::user()->email)->first()->familyid)->orderBy('birthdate')->get();
    }
}
