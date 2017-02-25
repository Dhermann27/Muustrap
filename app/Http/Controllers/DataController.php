<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function campers(Request $request)
    {
        $this->validate($request, ['term' => 'required|between:3,50']);
        return \App\Camper::where('lastname', 'LIKE', '%' . $request->term . '%')
            ->orWhere(DB::raw('CONCAT(firstname, " ", lastname)'), 'LIKE', '%' . $request->term . '%')
            ->orderBy('lastname')->orderBy('birthdate')->get();
    }

    public function churches(Request $request)
    {
        $this->validate($request, ['term' => 'required|between:3,50']);
        return \App\Church::where('name', 'LIKE', '%' . $request->term . '%')
            ->orWhere('city', 'LIKE', '%' . $request->term . '%')->orderBy('statecd')->orderBy('city')->orderBy('name')
            ->get();
    }
}
