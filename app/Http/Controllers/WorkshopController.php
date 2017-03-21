<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkshopController extends Controller
{
    public function store(Request $request)
    {

        $campers = $this->getCampers(\App\Camper::where('email', Auth::user()->email)->first()->familyid);

        foreach ($campers as $camper) {
            $this->validate($request, [$camper->id . '-workshops' => 'regex:/^\d{0,5}+(,\d{0,5})*$/']);

            $choices = \App\Yearattending__Workshop::where('yearattendingid', $camper->yearattendingid)
                ->get()->keyBy('workshopid');

            foreach (explode(',', $request->input($camper->id . '-workshops')) as $choice) {
                if ($choice != '') {
                    \App\Yearattending__Workshop::updateOrCreate(
                        ['yearattendingid' => $camper->yearattendingid, 'workshopid' => $choice],
                        ['yearattendingid' => $camper->yearattendingid, 'workshopid' => $choice]);

                    $choices->forget($choice);
                }
            }

            if (count($choices) > 0) {
                foreach ($choices as $choice) {
                    DB::statement('DELETE FROM yearattending__workshop WHERE yearattendingid=' .
                        $choice->yearattendingid . ' AND workshopid=' . $choice->workshopid);
                }
            }
        }

        DB::statement('CALL update_workshops;');

        $success = 'Your workshop selections have been updated. Check out available rooms by clicking <a href="' . url('/roomselection') . '">here</a>.';
        return $this->index($success);
    }

    private function getCampers($id)
    {
        return \App\Thisyear_Camper::where('familyid', $id)->orderBy('birthdate')->get();
    }

    public function index($success = null)
    {
        return view('workshopchoice', ['timeslots' => \App\Timeslot::all(),
            'campers' => $this->getCampers(\App\Camper::where('email', Auth::user()->email)->first()->familyid),
            'success' => $success
        ]);

    }

    public function write(Request $request, $id)
    {

        $campers = $this->getCampers($id);

        foreach ($campers as $camper) {

            $choices = \App\Yearattending__Workshop::where('yearattendingid', $camper->yearattendingid)
                ->get()->keyBy('workshopid');

            foreach (explode(',', $request->input($camper->id . '-workshops')) as $choice) {
                if ($choice != '') {
                    \App\Yearattending__Workshop::updateOrCreate(
                        ['yearattendingid' => $camper->yearattendingid, 'workshopid' => $choice],
                        ['yearattendingid' => $camper->yearattendingid, 'workshopid' => $choice]);

                    $choices->forget($choice);
                }
            }

            if (count($choices) > 0) {
                foreach ($choices as $choice) {
                    DB::statement('DELETE FROM yearattending__workshop WHERE yearattendingid=' .
                        $choice->yearattendingid . ' AND workshopid=' . $choice->workshopid);
                }
            }
        }

        DB::statement('CALL update_workshops;');

        $success = 'Green means good! Yayyyyyy';
        return $this->index($success);
    }

    public function read($i, $id, $success = null)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        return view('workshopchoice', ['timeslots' => \App\Timeslot::all(),
            'campers' => $this->getCampers($i == 'f' ? $id : \App\Camper::find($id)->familyid),
            'success' => $success, 'readonly' => $readonly]);
    }

    public function display()
    {
        return view('workshops', ['timeslots' => \App\Timeslot::all()->except('1005')]);
    }

}
