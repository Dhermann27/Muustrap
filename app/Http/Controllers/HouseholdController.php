<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HouseholdController extends Controller
{
    public function store(Request $request)
    {
        $id = 0;
        $messages = ['statecd.exists' => 'Please choose a state code or "ZZ" for international.',
            'zipcd.regex' => 'Please enter your 5-7 character zip code.'];

        $this->validate($request, [
            'name' => 'required|max:255',
            'address1' => 'required|max:255',
            'address2' => 'max:255',
            'city' => 'required|max:255',
            'statecd' => 'required|exists:statecodes,id',
            'zipcd' => 'required|regex:/^[a-zA-Z0-9]{5,7}$/',
            'is_ecomm' => 'required|in:0,1',
            'is_scholar' => 'required|in:0,1'
        ], $messages);

        $camper = Auth::user()->camper;
        if ($camper !== null) {
            $id = $camper->family->id;
        }

        $family = \App\Family::updateOrCreate(
            ['id' => $id],
            $request->only('name', 'address1', 'address2', 'city', 'statecd', 'zipcd', 'country', 'is_ecomm', 'is_scholar'));

        $camper = \App\Camper::updateOrCreate(['email' => Auth::user()->email],
            ['familyid' => $family->id, 'email' => Auth::user()->email]);

        $request->session()->flash('success', 'Your information has been saved successfully. Proceed to the next screen by clicking <a href="' . url('/camper') . '">here</a>.');

        return redirect()->action('HouseholdController@index', ['camper' => $camper, 'family' => $family]);

    }

    public function index($camper = null, $family = null)
    {
        if ($camper === null) {
            $camper = Auth::user()->camper;
        }
        if ($family === null) {
            if ($camper !== null) {
                $family = $camper->family;
                $id = $camper->id;
            } else {
                $family = new \App\Family();
                $id = 0;

            }
        }
        return view('household', ['formobject' => $family, 'steps' => $this->getSteps($id),
            'statecodes' => \App\Statecode::orderBy('name')->get()]);
    }

    public function write(Request $request, $id)
    {
        $family = \App\Family::updateOrCreate(
            ['id' => $id],
            $request->only('name', 'address1', 'address2', 'city', 'statecd', 'zipcd', 'country',
                'is_address_current', 'is_ecomm', 'is_scholar'));
        $success = 'Nice work! Need to make changes to the <a href="' . url('/camper/f/' . $family->id) . '">camper</a> next?';

        if ($id == 0) {
            \App\Camper::create(['familyid' => $family->id, 'firstname' => 'Mister', 'lastname' => 'MUUSA']);
            $success .= 'Since you just created a new family, I added a camper named &quot;Mister MUUSA&quot; to it if you need to find the family later. (Hint: not a real person.)';
        }

        $request->session()->flash('success', $success);

        return redirect()->action('HouseholdController@read', ['i' => 'f', 'id' => $id, 'family' => $family]);
    }

    public function read($i, $id, $family = null)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        if ($family === null) {
            $family = \App\Family::find($this->getFamilyId($i, $id));
        }

        if (empty($family)) {
            $family = new \App\Family();
            $family->id = 0;
            $id = 0;
        } else {
            $id = $family->id;
        }
        return view('household', ['formobject' => $family, 'steps' => $this->getSteps($id),
            'statecodes' => \App\Statecode::all()->sortBy('name'), 'readonly' => $readonly]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}
