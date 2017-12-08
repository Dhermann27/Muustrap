<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{

    public function store(Request $request)
    {

        $campers = $this->getCampers(\App\Camper::where('email', Auth::user()->email)->first()->familyid);

        foreach ($campers as $camper) {
            $this->validate($request, [$camper->id . '-volunteer' => 'regex:/^\d{0,5}+(,\d{0,5})*$/']);

            $choices = \App\Yearattending__Volunteer::where('yearattendingid', $camper->yearattendingid)
                ->get()->keyBy('volunteerpositionid');

            foreach (explode(',', $request->input($camper->id . '-volunteer')) as $choice) {
                if ($choice != '') {
                    \App\Yearattending__Volunteer::updateOrCreate(
                        ['yearattendingid' => $camper->yearattendingid, 'volunteerpositionid' => $choice],
                        ['yearattendingid' => $camper->yearattendingid, 'volunteerpositionid' => $choice]);

                    $choices->forget($choice);
                }
            }

            if (count($choices) > 0) {
                foreach ($choices as $choice) {
                    DB::statement('DELETE FROM yearattending__volunteer WHERE yearattendingid=' .
                        $choice->yearattendingid . ' AND volunteerpositionid=' . $choice->volunteerpositionid);
                }
            }
        }

        $request->session()->flash('success', 'Your volunteer positions have been updated.');
        return $this->index();
    }

    private function getCampers($id)
    {
        return \App\Thisyear_Camper::where('familyid', $id)->orderBy('birthdate')->get();
    }

    public function index()
    {
        return view('volunteer', ['positions' => \App\Volunteerposition::all(),
            'campers' => $this->getCampers(\App\Camper::where('email', Auth::user()->email)->first()->familyid)
        ]);

    }

    public function write(Request $request, $id)
    {

        $campers = $this->getCampers($id);

        foreach ($campers as $camper) {

            $choices = \App\Yearattending__Volunteer::where('yearattendingid', $camper->yearattendingid)
                ->get()->keyBy('volunteerpositionid');

            foreach (explode(',', $request->input($camper->id . '-volunteer')) as $choice) {
                if ($choice != '') {
                    \App\Yearattending__Volunteer::updateOrCreate(
                        ['yearattendingid' => $camper->yearattendingid, 'volunteerpositionid' => $choice],
                        ['yearattendingid' => $camper->yearattendingid, 'volunteerpositionid' => $choice]);

                    $choices->forget($choice);
                }
            }

            if (count($choices) > 0) {
                foreach ($choices as $choice) {
                    DB::statement('DELETE FROM yearattending__volunteer WHERE yearattendingid=' .
                        $choice->yearattendingid . ' AND volunteerpositionid=' . $choice->volunteerpositionid);
                }
            }
        }

        $request->session()->flash('success', 'I bet nobody reads these and all my clever quips are for nothing!');
        return $this->read('f', $id);
    }

    public function read($i, $id)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        return view('volunteer', ['positions' => \App\Volunteerposition::all(),  'readonly' => $readonly,
            'campers' => $this->getCampers($i == 'f' ? $id : \App\Camper::find($id)->familyid)]);
    }
}
