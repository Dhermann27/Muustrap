<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NametagController extends Controller
{
    public function store(Request $request)
    {
        $campers = $this->getCampers();

        $this->validate($request, [
            '*-nametag-*' => 'required|between:1,7'
        ]);

        foreach ($campers as $camper) {
            $this->updateCamper($request, $camper);
        }

        $request->session()->flash('success', 'You have successfully customized your nametag(s).');

        return $this->index($campers);

    }

    private function getCampers()
    {
        return \App\Thisyear_Camper::where('familyid', \App\Camper::where('email', Auth::user()->email)->first()->familyid)->orderBy('birthdate')->get();
    }

    private function updateCamper($request, $camper)
    {
        $nametag = $request->input($camper->id . '-nametag-pronoun');
        $nametag .= $request->input($camper->id . '-nametag-name');
        $nametag .= $request->input($camper->id . '-nametag-namesize');
        $nametag .= $request->input($camper->id . '-nametag-line1');
        $nametag .= $request->input($camper->id . '-nametag-line2');
        $nametag .= $request->input($camper->id . '-nametag-line3');
        $nametag .= $request->input($camper->id . '-nametag-line4');
        $nametag .= $request->input($camper->id . '-nametag-fontapply');
        $nametag .= $request->input($camper->id . '-nametag-font');
        $camper->yearattending->nametag = $nametag;
        $camper->yearattending->save();
    }

    public function index($campers = null)
    {
        if ($campers == null) {
            $campers = $this->getCampers();
        }
        return view('nametags', ['campers' => $campers]);
    }

    public function write(Request $request, $id)
    {

        $campers = \App\Thisyear_Camper::where('familyid', $id)->get();

        foreach ($campers as $camper) {
            $this->updateCamper($request, $camper);
        }

        $request->session()->flash('success', 'It worked, but did you ever consider that all of this is meaningless in the grand scheme of things?');

        return $this->read('f', $id);
    }

    public function read($i, $id)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        $campers = \App\Thisyear_Camper::where('familyid', $this->getFamilyId($i, $id))->orderBy('birthdate')->get();

        return view('nametags', ['campers' => $campers, 'readonly' => $readonly]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Thisyear_Camper::find($id)->familyid : $id;
    }
}
