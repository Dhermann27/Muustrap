<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkshopController extends Controller
{
    public function store(Request $request)
    {

        $year = \App\Year::where('is_current', '1')->first();
        $campers = $this->getCampers(Auth::user()->camper->familyid);

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

        DB::statement('CALL workshops();');
        DB::statement('CALL generate_charges(' . $year->year . ');');

        $success = 'Your workshop selections have been updated.';
        if ($year->is_live) $success .= ' Check out available rooms by clicking <a href="' . url('/roomselection') . '">here</a>.';

        $request->session()->flash('success', $success);

        return redirect()->action('WorkshopController@index');
    }

    public function index(Request $request)
    {
        if (!isset(Auth::user()->camper)) {
            $request->session()->flash('warning', 'You have not yet created your household information.');
            return redirect()->action('HouseholdController@index');
        }
        $campers = $this->getCampers(Auth::user()->camper->familyid);
        if (count($campers) == 0) {
            $request->session()->flash('warning', 'You have no campers registered for this year.');
            return redirect()->action('CamperController@index');
        }
        return view('workshopchoice', ['timeslots' => \App\Timeslot::with('workshops.choices')->get(),
            'campers' => $campers
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

        DB::statement('CALL workshops();');
        DB::statement('CALL generate_charges(getcurrentyear());');

        $request->session()->flash('success', 'Green means good! Yayyyyyy');

        redirect()->action('WorkshopController@read', ['i' => 'f', 'id' => $id]);
    }

    public function read($i, $id)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        return view('workshopchoice', ['timeslots' => \App\Timeslot::with('workshops.choices')->get(),
            'campers' => $this->getCampers($i == 'f' ? $id : \App\Camper::find($id)->familyid),
            'readonly' => $readonly]);
    }

    public function display()
    {
        return view('workshops', ['timeslots' => \App\Timeslot::all()->except('1005'), 'background' => 'workshops.jpg']);
    }

    public function excursions()
    {
        return view('excursions', ['timeslot' => \App\Timeslot::where('id', '1005')->first()]);

    }

    private function getCampers($id)
    {
        return \App\Thisyear_Camper::where('familyid', $id)->with('yearattending.workshops')->orderBy('birthdate')->get();
    }

}
