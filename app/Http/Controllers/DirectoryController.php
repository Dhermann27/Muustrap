<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectoryController extends Controller
{
    public function index()
    {

        $years = \App\Yearattending::select('year')
            ->where('camperid', Auth::user()->camper->id)->get();
        return view('directory', ['letters' => \App\Byyear_Family::select('id', DB::raw('LEFT(`name`, 1) AS first'), 'name', 'address1', 'address2', 'city', 'statecd', DB::raw('GROUP_CONCAT(`year`) AS years'))
            ->groupBy('id')->whereIn('year', $years)->orderBy('name')->orderBy('statecd')->orderBy('city')->get(),
            'campers' => \App\Camper::orderBy('birthdate')->get()->groupBy('familyid')]);
    }
}
