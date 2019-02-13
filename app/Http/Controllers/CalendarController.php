<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function read($id)
    {
        return view('calendar', ['campers' => \App\Thisyear_Camper::where('familyid', \App\Thisyear_Camper::find($id)->familyid)
            ->orderBy('birthdate')->get()]);
    }

    public function index()
    {
        return view('calendar', ['campers' => \App\Thisyear_Camper::where('familyid', Auth::user()->thiscamper->familyid)
            ->orderBy('birthdate')->get()]);
    }
}
