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
            'zipcd.regex' => 'Please enter your five-digit zip code.'];

        $this->validate($request, [
            'name' => 'required|max:255',
            'address1' => 'required|max:255',
            'address2' => 'max:255',
            'city' => 'required|max:255',
            'statecd' => 'required|exists:statecodes,code',
            'zipcd' => 'required|regex:/^\d{5}$/',
            'is_ecomm' => 'required|in:0,1',
            'is_scholar' => 'required|in:0,1'
        ], $messages);

        $camper = \App\Camper::where('email', Auth::user()->email)->first();
        if ($camper !== null) {
            $id = $camper->family->id;
        }

        $family = \App\Family::updateOrCreate(
            ['id' => $id],
            $request->only('name', 'address1', 'address2', 'city', 'statecd', 'zipcd', 'country', 'is_ecomm', 'is_scholar'));

        \App\Camper::updateOrCreate(
            ['email' => Auth::user()->email],
            ['familyid' => $family->id, 'email' => Auth::user()->email, 'updated_at' => null]
        );

        return view('household', ['family' => $family, 'statecodes' => \App\Statecode::all()->sortBy('name'),
            'message' => 'Your information has been saved successfully. Proceed to the next screen by clicking <a href="' . url('/camper') . '">here</a>.']);

    }

    public function index()
    {
        $camper = \App\Camper::where('email', Auth::user()->email)->first();
        $family = $camper !== null ? $camper->family : new \App\Family();
        return view('household', ['family' => $family, 'statecodes' => \App\Statecode::all()->sortBy('name')]);
    }

    public function write(Request $request, $id)
    {
        $family = \App\Family::updateOrCreate(
            ['id' => $id],
            $request->only('name', 'address1', 'address2', 'city', 'statecd', 'zipcd', 'country', 'is_ecomm', 'is_scholar'));

        return view('household', ['family' => $family, 'statecodes' => \App\Statecode::all()->sortBy('name'),
            'message' => 'Nice work! Need to make changes to the <a href="' . url('/camper/f/' . $id) . '">camper</a> next?']);
    }

    public function read($i, $id)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        $family = \App\Family::where('id', $this->getFamilyId($i, $id))->first();
        return view('household', ['family' => $family,
            'statecodes' => \App\Statecode::all()->sortBy('name'), 'readonly' => $readonly]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::where('id', $id)->first()->familyid : $id;
    }
}
