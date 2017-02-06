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

        foreach ($campers as $camper) {
            $messages = [$camper->id . 'phonenbr.regex' => 'Please enter your ten-digit phone number in 800-555-1212 format.',
                $camper->id . 'birthdate.regex' => 'Please enter your eight-digit birthdate in 2016-12-31 format.'];

            $this->validate($request, [
                $camper->id . '-yearattendingid' => 'required|between:0,99999',
                $camper->id . '-pronounid' => 'required|exists:pronouns,id',
                $camper->id . '-firstname' => 'required|max:255',
                $camper->id . '-lastname' => 'required|max:255',
                $camper->id . '-email' => 'email|max:255',
                $camper->id . '-phonenbr' => 'regex:/^\d{3}-\d{3}-\d{4}$/',
                $camper->id . '-birthdate' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/',
                $camper->id . '-roommate' => 'max:255',
                $camper->id . '-sponsor' => 'max:255',
                $camper->id . '-churchid' => 'exists:churches,id',
                $camper->id . '-is_handicap' => 'required|in:0,1',
                $camper->id . '-foodoptionid' => 'required|exists:foodoptions,id',
            ], $messages);
        }

        foreach ($campers as $camper) {
            if ($camper->email == $logged_in) {
                Auth::user()->email = $request->input($camper->id . '-email');
                Auth::user()->save();
            }

            $camper->pronounid = $request->input($camper->id . '-pronounid');
            $camper->firstname = $request->input($camper->id . '-firstname');
            $camper->lastname = $request->input($camper->id . '-lastname');

            if ($request->input($camper->id . '-email') != '') {
                $camper->email = $request->input($camper->id . '-email');
            }
            if ($request->input($camper->id . '-phonenbr') != '') {
                $camper->phonenbr = str_replace('-', '', $request->input($camper->id . '-phonenbr'));
            }
            $camper->birthdate = $request->input($camper->id . '-birthdate');
            $camper->roommate = $request->input($camper->id . '-roommate');
            $camper->sponsor = $request->input($camper->id . '-sponsor');
            $camper->churchid = $request->input($camper->id . '-churchid');
            $camper->is_handicap = $request->input($camper->id . '-is_handicap');
            $camper->foodoptionid = $request->input($camper->id . '-foodoptionid');

            $camper->save();

            if ($request->input($camper->id . '-yearattendingid') == '1') {
                $ya = \App\Yearattending::updateOrCreate(['camperid' => $camper->id,
                    'year' => DB::raw('getcurrentyear()')], []);
                $camper->yearattendingid = $ya->id;

                if ($camper->email != '') {
                    $ua = [];
                    $ua['email'] = $camper->email;
                    $ua['name'] = $camper->firstname . ' ' . $camper->lastname;
                    $emailsToSend[count($emailsToSend)] = (object)$ua;
                }
            } else {
                $ya = \App\Yearattending::where(['camperid' => $camper->id,
                    'year' => DB::raw('getcurrentyear()')])->first();
                if ($ya != null) {
                    if ($request->input($camper->id . '-yearattendingid') == '0') {
                        $ya->delete();
                    } else {
                        // Just update timestamp for now
                        $ya->update();
                    }
                }
            }

        }

        DB::statement('CALL generate_charges();');

        $year = $this->getCurrentYear();
        Mail::to($emailsToSend)->send(new Confirm($year, $campers));

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

    public function index($success = null, $year = null, $campers = null)
    {
        if ($year == null) {
            $year = $this->getCurrentYear();
        }
        if ($campers == null) {
            $campers = $this->getCampers();
        }
        return view('campers', ['pronouns' => \App\Pronoun::all(), 'foodoptions' => \App\Foodoption::all(),
            'year' => $year, 'campers' => $campers, 'success' => $success]);

    }
}
