<?php

namespace App\Http\Controllers;

class WorkshopController extends Controller
{
    public function store(Request $request) {
        $success = '';
        $this->index($success);

    }

    public function index($success) {
        return view('workshopchoice', ['timeslots' => \App\Timeslot::all(),
            'success' => $success
        ]);

    }

    public function read()
    {
        return view('workshops', ['timeslots' => \App\Timeslot::all()->except('1005')]);
    }

}
