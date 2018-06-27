<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfirmController extends Controller
{
    public function read($i, $id)
    {
        return view('confirm', ['families' => \App\Thisyear_Family::where('id', $this->getFamilyId($i, $id))->get(),
            'medical' => \App\Program::find(DB::raw('getprogramidbyname("Adult")'))->form]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }

    public function respond(Request $request, $id)
    {
        $logged_in = \App\Thisyear_Camper::where('email', Auth::user()->email)->first();

        $messages = ['*-parent_name.required' => 'All children must identify their parent or guardian.',
            '*-mobile_phone.required' => 'All children must enter a mobile contact number in case of emergency.',
            '*-mobile_phone.regex' => 'Please enter your ten-digit phone number in 800-555-1212 format.',
            '*-doctor_name.required' => 'All children must identify a doctor to contact in case of emergency.',
            '*-doctor_nbr.required' => 'All children must identify a doctor to contact in case of emergency.',
            '*-doctor_nbr.regex' => 'Please enter your ten-digit phone number in 800-555-1212 format.',
            '*-holder_birthday.required' => 'Please enter your eight-digit birthdate in 2016-12-31 format.',
            '*-carrier_nbr.regex' => 'Please enter your ten-digit phone number in 800-555-1212 format.'];

        $this->validate($request, [
            '*-parent_name' => 'required|max:255',
            '*-youth_sponsor' => 'max:255',
            '*-mobile_phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/',
            '*-concerns' => 'max:2000',
            '*-doctor_name' => 'required|max:255',
            '*-doctor_nbr' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/',
            '*-is_insured' => 'in:0,1',
            '*-holder_name' => 'max:255',
            '*-holder_birthday' => 'regex:/^\d{4}-\d{2}-\d{2}$/',
            '*-carrier' => 'max:255',
            '*-carrier_nbr' => 'regex:/^\d{3}-\d{3}-\d{4}$/',
            '*-carrier_id' => 'numeric',
            '*-carrier_group' => 'numeric'
        ], $messages);

        if ($logged_in && (in_array($id, $logged_in->family->campers()->pluck('yearattendingid')->all()) || \Entrust::can('write'))) {
            $response = \App\Medicalresponse::firstOrNew(['yearattendingid' => $id]);
            $response->parent_name = $request->input($id . '-parent_name');
            $response->youth_sponsor = $request->input($id . '-youth_sponsor');
            $response->mobile_phone = $request->input($id . '-mobile_phone');
            $response->concerns = $request->input($id . '-concerns');
            $response->doctor_name = $request->input($id . '-doctor_name');
            $response->doctor_nbr = $request->input($id . '-doctor_nbr');
            $response->is_insured = $request->input($id . '-is_insured');
            if ($response->is_insured == '1') {
                $response->holder_name = $request->input($id . '-holder_name');
                $response->holder_birthday = $request->input($id . '-holder_birthday');
                $response->carrier = $request->input($id . '-carrier');
                $response->carrier_nbr = $request->input($id . '-carrier_nbr');
                $response->carrier_id = $request->input($id . '-carrier_id');
                $response->carrier_group = $request->input($id . '-carrier_group');
                $response->is_epilepsy = $request->input($id . '-is_epilepsy') == "on";
                $response->is_diabetes = $request->input($id . '-is_diabetes') == "on";
                $response->is_add = $request->input($id . '-is_add') == "on";
                $response->is_adhd = $request->input($id . '-is_adhd') == "on";
            }
            $response->save();
        } else {
            return "You are not authorized to change this response.";
        }

        return 'You have successfully saved your response.';
    }

    public function index()
    {
        return view('confirm', ['families' => \App\Thisyear_Family::where('id', \App\Camper::where('email', Auth::user()->email)->first()->familyid)->get(),
            'medical' => \App\Program::find(DB::raw('getprogramidbyname("Adult")'))->form]);

    }

    public function all()
    {
        return view('confirm', ['families' => \App\Thisyear_Family::orderBy('name')->get()]);

    }

    public function letters()
    {
        return view('medicals', ['campers' => \App\Thisyear_Camper::where('age', '<', '18')
            ->orderBy('programid')->orderBy('lastname')->get()]);

    }
}
