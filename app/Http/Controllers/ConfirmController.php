<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfirmController extends Controller
{
    public function read($i, $id) {
        return view('confirm', ['year' => \App\Year::where('is_current', '1')->first(),
            'families' => \App\Thisyear_Family::where('id', $this->getFamilyId($i, $id))->get(),
            'medical' => \App\Program::find(DB::raw('getprogramidbyname("Adult", getcurrentyear())'))->form]);
    }

    public function index()
    {
        return view('confirm', ['year' => \App\Year::where('is_current', '1')->first(),
            'families' => \App\Thisyear_Family::where('id', \App\Camper::where('email', Auth::user()->email)->first()->familyid)->get(),
            'medical' => \App\Program::find(DB::raw('getprogramidbyname("Adult", getcurrentyear())'))->form]);

    }

    public function all() {
        return view('confirm', ['year' => \App\Year::where('is_current', '1')->first(),
            'families' => \App\Thisyear_Family::with('campers.yearattending.workshops.workshop')->get()]);

    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}
