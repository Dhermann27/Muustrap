<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function churches(Request $request)
    {
        $this->validate($request, ['term' => 'required|between:3,50']);
        return \App\Church::where('name', 'LIKE', '%' . $request->term . '%')
            ->orWhere('city', 'LIKE', '%' . $request->term . '%')->orderBy('statecd')->orderBy('city')->orderBy('name')
            ->get();
    }
}
