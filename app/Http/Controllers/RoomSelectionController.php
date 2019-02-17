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
            'familyid' => Auth::user()->thiscamper->familyid])->get();
        foreach ($family as $item) {
            $ya = \App\Yearattending::find($item->yearattendingid);
            $ya->roomid = $request->roomid;
            $ya->save();
        }

        DB::statement('CALL generate_charges(getcurrentyear());');

        $success = 'Room selection complete! Your room is locked in for the ' . count($family) . ' eligible members of your household.';
        if (\App\Year::where('is_current', '1')->first()->is_live) $success .= ' Customize your nametag by clicking <a href="' . url('/nametag') . '">here</a>.';

        $request->session()->flash('success', $success);

        return redirect()->action('RoomSelectionController@index', ['request' => $request]);
    }

    public function index(Request $request)
    {
        if (!isset(Auth::user()->camper)) {
            $request->session()->flash('warning', 'You have not yet created your household information.');
            return redirect()->action('HouseholdController@index');
        }
        if (!isset(Auth::user()->thiscamper)) {
            $request->session()->flash('warning', 'You have no campers registered for this year.');
            return redirect()->action('CamperController@index');
        }

        $camper = Auth::user()->thiscamper;
        $locked = $camper->yearattending->is_setbyadmin == '1' || $camper->is_program_housing == '1';
        $count = \App\Thisyear_Camper::where('familyid', $camper->familyid)->where('is_program_housing', '0')->count();
        $rooms = DB::select('SELECT r.id, r.buildingid, b.name buildingname, r.room_number, r.capacity, r.xcoord, 
            r.ycoord, r.pixelsize, rp.room_number connected_with,
            GROUP_CONCAT(CONCAT(c.firstname, \' \', c.lastname) ORDER BY c.birthdate SEPARATOR \'<br />\') names,
            IF(c.id IS NULL OR r.capacity>=10,1,0) available FROM (rooms r, buildings b)
            LEFT OUTER JOIN (yearsattending ya, campers c) ON r.id=ya.roomid AND ya.year=' . $this->year->year . ' AND ya.camperid=c.id 
            LEFT OUTER JOIN rooms rp ON r.connected_with=rp.id WHERE r.buildingid=b.id AND r.xcoord>0 AND r.ycoord>0 
            GROUP BY id');

        if ($locked) {
            $request->session()->flash('warning', 'Your room has been locked by the Registrar. Please use the Contact Us form above to request any changes at this point.');
        }

        return view('roomselection', ['rooms' => $rooms, 'camper' => $camper, 'count' => $count,
            'locked' => $locked, 'steps' => $this->getSteps()]);
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
            if($ya->roomid == 0) $ya->roomid = null;
            $ya->is_setbyadmin = '1';
            $ya->save();
        }

        DB::statement('CALL generate_charges(getcurrentyear());');

        $request->session()->flash('success', 'Awwwwwwww yeahhhhhhhhh');

        return redirect()->action('RoomSelectionController@read', ['i' => 'f', 'id' => $id]);
    }

    public function read($i, $id)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        $family = \App\Family::find($this->getFamilyId($i, $id));
        $campers = \App\Thisyear_Camper::where('familyid', $family->id)->with('yearsattending.room.building')
            ->orderBy('birthdate')->get();

        return view('admin.rooms', ['buildings' => \App\Building::with('rooms.occupants')->get(),
            'campers' => $campers, 'readonly' => $readonly, 'steps' => $this->getSteps()]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}
