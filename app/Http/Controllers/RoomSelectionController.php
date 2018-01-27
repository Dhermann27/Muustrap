<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomSelectionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, ['roomid' => 'required|numeric|between:999,99999']);

        $family = \App\Thisyear_Camper::where(['is_program_housing' => '0',
            'familyid' => \App\Thisyear_Camper::where('email', Auth::user()->email)->first()->familyid])->get();
        foreach ($family as $item) {
            $ya = \App\Yearattending::find($item->yearattendingid);
            $ya->roomid = $request->roomid;
            $ya->save();
        }

        DB::statement('CALL generate_charges(getcurrentyear());');

        $success = 'Room selection complete! Your room is locked in for the ' . count($family) . ' eligible members of your household.';
        if ($year->isLive()) $success .= ' Customize your nametag by clicking <a href="' . url('/nametag') . '">here</a>.';

        $request->session()->flash('success', $success);

        return $this->index($request);
    }

    public function index(Request $request)
    {
        $camper = \App\Thisyear_Camper::where('email', Auth::user()->email)->first();
        $count = \App\Thisyear_Camper::where('familyid', $camper->familyid)->where('is_program_housing', '0')->count();
        $rooms = \App\Room::where('xcoord', '>', '0')->where('ycoord', '>', '0')->get();

        if (isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '1') {
            $request->session()->flash('warning', 'Your room has been locked by the Registrar. Please use the Contact Us form above to request any changes at this point.');
        }

        return view('roomselection', ['rooms' => $rooms, 'camper' => $camper, 'count' => $count]);
    }

    public function map()
    {
        $empty = new \App\Camper();
        $rooms = \App\Room::where('xcoord', '>', '0')->where('ycoord', '>', '0')->get();
        return view('roomselection', ['camper' => $empty, 'rooms' => $rooms]);
    }

    public function write(Request $request, $id)
    {

        $campers = \App\Thisyear_Camper::where('familyid', $id)->get();

        foreach ($campers as $camper) {
            $ya = \App\Yearattending::find($camper->yearattendingid);
            $ya->roomid = $request->input($camper->id . '-roomid');
            $ya->is_setbyadmin = '1';
            $ya->save();
        }

        DB::statement('CALL generate_charges(getcurrentyear());');

        $request->session()->flash('success', 'Awwwwwwww yeahhhhhhhhh');

        return $this->read('f', $id);
    }

    public function read($i, $id)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        $family = \App\Family::find($this->getFamilyId($i, $id));
        $campers = \App\Thisyear_Camper::where('familyid', $family->id)->orderBy('birthdate')->get();

        return view('admin.rooms', ['buildings' => \App\Building::with('rooms')->get(),
            'campers' => $campers, 'readonly' => $readonly]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}
