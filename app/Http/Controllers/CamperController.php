<?php

namespace App\Http\Controllers;

use App\Mail\Confirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CamperController extends Controller
{

    public function store(Request $request)
    {
        $logged_in = \App\Camper::where('email', Auth::user()->email)->first();

        $messages = ['pronounid.*.exists' => 'Please choose a preferred pronoun.',
            'firstname.*.required' => 'Please enter a first name.',
            'lastname.*.required' => 'Please enter a last name.',
            'email.*.email' => 'Please enter a valid email address.',
            'email.*.distinct' => 'Please do not use the same email address for multiple campers.',
            'phonenbr.*.regex' => 'Please enter your ten-digit phone number in 800-555-1212 format.',
            'birthdate.*.required' => 'Please enter your eight-digit birthdate in 2016-12-31 format.',
            'birthdate.*.regex' => 'Please enter your eight-digit birthdate in 2016-12-31 format.'];

        $this->validate($request, [
            'days.*' => 'between:0,7',
            'pronounid.*' => 'exists:pronouns,id',
            'firstname.*' => 'required|max:255',
            'lastname.*' => 'required|max:255',
            'email.*' => 'email|max:255|distinct',
            'phonenbr.*' => 'regex:/^\d{3}-\d{3}-\d{4}$/',
            'birthdate.*' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/',
            'roommate.*' => 'max:255',
            'sponsor.*' => 'max:255',
            'churchid.*' => 'exists:churches,id',
            'is_handicap.*' => 'in:0,1',
            'foodoptionid.*' => 'exists:foodoptions,id',
        ], $messages);

        for ($i = 0; $i < count($request->input('id')); $i++) {
            $id = $request->input('id')[$i];
            $camper = \App\Camper::find($id);
            if ($id == $logged_in->id) {
                Auth::user()->email = $request->input('email')[$i];
                Auth::user()->save();
            }
            if ($id == 0 || $camper->familyid == $logged_in->familyid) {
                $this->upsertCamper($request, $i, $logged_in->familyid);
            }
        }

//        $year = $this->getCurrentYear();
//
//        DB::statement('CALL generate_charges(' . $this->getCurrentYear()->year . ');');
//
//        Mail::to(Auth::user()->email)->send(new Confirm($year, $campers));

        return 'You have successfully saved your changes and registered. Click <a href="' . url('/payment') . '">here</a> to remit payment.';
    }

    private function upsertCamper(Request $request, $i, $familyid)
    {
        if ($request->input('id')[$i] != '0') {
            $camper = \App\Camper::findOrFail($request->input('id')[$i]);
        } else {
            $camper = new \App\Camper;
        }
        $camper->familyid = $familyid;
        $camper->pronounid = $request->input('pronounid')[$i];
        $camper->firstname = $request->input('firstname')[$i];
        $camper->lastname = $request->input('lastname')[$i];

        if ($request->input('email')[$i] != '') {
            $camper->email = $request->input('email')[$i];
        }
        if ($request->input('phonenbr')[$i] != '') {
            $camper->phonenbr = str_replace('-', '', $request->input('phonenbr')[$i]);
        }
        $camper->birthdate = $request->input('birthdate')[$i];
        $camper->gradeoffset = DB::raw("(SELECT " . $request->input('gradeoffset')[$i] . "-getage('" . $camper->birthdate . "',getcurrentyear()))");
        $camper->roommate = $request->input('roommate')[$i];
        $camper->sponsor = $request->input('sponsor')[$i];
        $camper->churchid = $request->input('churchid')[$i];
        $camper->is_handicap = $request->input('is_handicap')[$i];
        $camper->foodoptionid = $request->input('foodoptionid')[$i];

        $camper->save();

        if ((int)$request->input('days')[$i] > 0) {
            $ya = \App\Yearattending::updateOrCreate(['camperid' => $camper->id,
                'year' => DB::raw('getcurrentyear()')], ['days' => $request->input('days')[$i]]);
            $camper->yearattendingid = $ya->id;
        } else {
            $ya = \App\Yearattending::where(['camperid' => $camper->id, 'year' => DB::raw('getcurrentyear()')])->first();
            if ($ya != null) {
                if ($request->input('days')[$i] == '0') {
                    \App\Yearattending__Workshop::where('yearattendingid', $ya->id)->delete();
                    \App\Yearattending__Staff::where('yearattendingid', $ya->id)->delete();
                    $ya->delete();
                } else {
                    $ya->days = $request->input('days')[$i];
                    $ya->update();
                }
            }
        }

        return $camper;
    }

    private function getCurrentYear()
    {
        return \App\Year::where('is_current', 1)->first();
    }

    public function index($success = null, $year = null, $campers = null)
    {
        if ($year == null) {
            $year = $this->getCurrentYear();
        }
        if ($campers == null) {
            $campers = $this->getCampers();
        }
        $empty = new \App\Camper();
        $empty->id = 0;
        $empty->churchid = 2084;
        return view('campers', ['pronouns' => \App\Pronoun::all(), 'foodoptions' => \App\Foodoption::all(),
            'year' => $year, 'campers' => $campers, 'empties' => array($empty), 'success' => $success, 'readonly' => null]);

    }

    private function getCampers()
    {
        return \App\Camper::where('familyid', \App\Camper::where('email', Auth::user()->email)->first()->familyid)->orderBy('birthdate')->get();
    }

    public function write(Request $request, $id)
    {

        for ($i = 0; $i < count($request->input('id')); $i++) {
            $this->upsertCamper($request, $i, $id);
        }

        DB::statement('CALL generate_charges(getcurrentyear());');

        return $this->read('f', $id, 'You did it! Need to make see their <a href="' . url('/payment/f/' . $id) . '">statement</a> next?');
    }

    public function read($i, $id, $success = null)
    {
        $year = $this->getCurrentYear();
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        $family = \App\Family::find($this->getFamilyId($i, $id));
        $campers = \App\Camper::where('familyid', $family->id)->orderBy('birthdate')->get();

        $empty = new \App\Camper();
        $empty->id = 0;
        $empty->churchid = 2084;
        $campers->push($empty);

        return view('campers', ['pronouns' => \App\Pronoun::all(), 'foodoptions' => \App\Foodoption::all(),
            'year' => $year, 'campers' => $campers, 'success' => $success, 'readonly' => $readonly]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}
