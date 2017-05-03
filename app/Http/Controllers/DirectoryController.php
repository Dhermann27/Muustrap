<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectoryController extends Controller
{
    public function index()
    {
        $years = \App\Yearattending::select('year')
            ->where('camperid', \App\Camper::where('email', Auth::user()->email)->first()->id)->get();
        return view('directory', ['letters' => \App\Byyear_Family::select('id', DB::raw('LEFT(`name`, 1) AS first'), 'name', 'city', 'statecd', DB::raw('GROUP_CONCAT(`year`) AS years'))
            ->groupBy('id')->whereIn('year', $years)->with('campers')->orderBy('name')
            ->orderBy('statecd')->orderBy('city')->get()]);
    }
}
