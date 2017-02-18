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
        $campers = $this->getCampers();
        $emailsToSend = [];

        $messages = ['*-email.distinct' => 'Please do not use the same email address for multiple campers.',
            '*-phonenbr.regex' => 'Please enter your ten-digit phone number in 800-555-1212 format.',
            '*-birthdate.regex' => 'Please enter your eight-digit birthdate in 2016-12-31 format.'];

        $this->validate($request, [
            '*-yearattendingid' => 'between:0,99999',
            '*-pronounid' => 'exists:pronouns,id',
            '*-firstname' => 'max:255',
            '*-lastname' => 'max:255',
            '*-email' => 'email|max:255|distinct',
            '*-phonenbr' => 'regex:/^\d{3}-\d{3}-\d{4}$/',
            '*-birthdate' => 'regex:/^\d{4}-\d{2}-\d{2}$/',
            '*-roommate' => 'max:255',
            '*-sponsor' => 'max:255',
            '*-churchid' => 'exists:churches,id',
            '*-is_handicap' => 'in:0,1',
            '*-foodoptionid' => 'exists:foodoptions,id',
        ], $messages);

        foreach ($campers as $camper) {
            if ($camper->email == $logged_in) {
                Auth::user()->email = $request->input($camper->id . '-email');
                Auth::user()->save();
            }
            $this->upsertCamper($request, $camper, $camper->id);
        }

        $i = 100;
        while ($request->input($i . '-yearattendingid') == '1') {
            $camper = new \App\Camper;
            $camper->familyid = $logged_in->familyid;
            $camper = $this->upsertCamper($request, $camper, $i++);
        }


        DB::statement('CALL generate_charges();');

        $year = $this->getCurrentYear();
        Mail::to(Auth::user()->email)->send(new Confirm($year, $campers));

        return $this->index('You have successfully saved your changes and registered. Click <a href="/payment">here</a> to remit payment.', $year, $campers);
    }

    private function getCampers()
    {
        return \App\Camper::where('familyid', \App\Camper::where('email', Auth::user()->email)->first()->familyid)->orderBy('birthdate')->get();
    }

    private function getCurrentYear()
    {
        return \App\Year::where('is_current', 1)->first();
    }

    private function upsertCamper($request, $camper, $id)
    {
        $camper->pronounid = $request->input($id . '-pronounid');
        $camper->firstname = $request->input($id . '-firstname');
        $camper->lastname = $request->input($id . '-lastname');

        if ($request->input($id . '-email') != '') {
            $camper->email = $request->input($id . '-email');
        }
        if ($request->input($id . '-phonenbr') != '') {
            $camper->phonenbr = str_replace('-', '', $request->input($id . '-phonenbr'));
        }
        $camper->birthdate = $request->input($id . '-birthdate');
        $camper->roommate = $request->input($id . '-roommate');
        $camper->sponsor = $request->input($id . '-sponsor');
        $camper->churchid = $request->input($id . '-churchid');
        $camper->is_handicap = $request->input($id . '-is_handicap');
        $camper->foodoptionid = $request->input($id . '-foodoptionid');

        $camper->save();

        if ($request->input($id . '-yearattendingid') == '1') {
            $ya = \App\Yearattending::updateOrCreate(['camperid' => $camper->id,
                'year' => DB::raw('getcurrentyear()')], []);
            $camper->yearattendingid = $ya->id;
        } else {
            $ya = \App\Yearattending::where(['camperid' => $camper->id,
                'year' => DB::raw('getcurrentyear()')])->first();
            if ($ya != null) {
                if ($request->input($id . '-yearattendingid') == '0') {
                    $ya->delete();
                } else {
                    // Just update timestamp for now
                    $ya->update();
                }
            }
        }

        return $camper;
    }

    public function index($success = null, $year = null, $campers = null)
    {
        if ($year == null) {
            $year = $this->getCurrentYear();
        }
        if ($campers == null) {
            $campers = $this->getCampers();
            $empty = new \App\Camper();
            $empty->id = 0;
            $empty->churchid = 2084;
            $campers->push($empty);
        }
        return view('campers', ['pronouns' => \App\Pronoun::all(), 'foodoptions' => \App\Foodoption::all(),
            'year' => $year, 'campers' => $campers, 'success' => $success]);

    }
}
