<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        return $this->index('Room selection complete! Your room is locked in for the ' . count($family) . ' eligible members of your household.');
    }

    public function index($success = null)
    {
        $trueopen = Carbon::createFromFormat('Y-m-d', \App\Year::where('is_current', '1')->first()->start_open)->addDays(30);
        $priorityperiod = Carbon::now()->lt($trueopen);
        if ($priorityperiod) {
            // TODO: Kill this with fire after prereg ends
            $rooms = DB::select('SELECT r.id, CONCAT(b.name,IF(b.id<1007,CONCAT(", Room ",r.room_number),""),IF(r.connected_with IS NULL,"",IF(rp.buildingid=1000,CONCAT("<br /><i>Double Privacy Door with Room ",rp.room_number,"</i>"),CONCAT("<br /><i>Shares common area with Room ",rp.room_number,"</i>")))) room_name, r.capacity, r.xcoord, r.ycoord, r.pixelsize, rp.room_number connected, (SELECT IF(ya.is_private=1,\'1\',GROUP_CONCAT(c.firstname, \' \', c.lastname SEPARATOR \'<br />\')) FROM campers c, yearsattending ya, years y WHERE c.id=ya.camperid AND r.id=ya.roomid AND y.year=ya.year AND y.is_current=1) AS occupants, (SELECT IF(ya.is_private=1,\'1\',GROUP_CONCAT(c.firstname, \' \', c.lastname SEPARATOR \'<br />\')) FROM (campers c, yearsattending ya, years y) LEFT OUTER JOIN thisyear_campers tc ON tc.id=c.id AND tc.roomid!=0 WHERE c.id=ya.camperid AND r.id=ya.roomid AND y.year-1=ya.year AND isprereg(c.id, y.year)>0 AND y.is_current=1 AND tc.id IS NULL) AS locked FROM buildings b, rooms r LEFT JOIN rooms rp ON r.connected_with=rp.id WHERE b.id=r.buildingid AND r.xcoord>0 AND r.ycoord>0');
            $camper = \App\Camper::where('email', Auth::user()->email)->first();
            $yaid = DB::select('SELECT IF(ya.id!=0,ya.id,IF(isprereg(c.id, y.year)>0 AND IFNULL(yap.id,0)!=0,yap.id,0)) yaid, isprereg(c.id, y.year) prereg FROM (campers c, years y) LEFT JOIN yearsattending ya ON c.id=ya.camperid AND y.year=ya.year LEFT JOIN yearsattending yap ON c.id=yap.camperid AND y.year-1=yap.year WHERE c.email=? AND y.is_current=1', [$camper->email]);
            if (count($yaid) == 1) {
                $camper->yearattending = \App\Yearattending::find($yaid[0]->yaid);
                $camper->prereg = $yaid[0]->prereg > 0;
            }
        } else {
            $camper = \App\Thisyear_Camper::where('email', Auth::user()->email)->first();
            $rooms = \App\Room::where('xcoord', '>', '0')->where('ycoord', '>', '0')->get();
        }
        return view('roomselection', ['open' => $trueopen, 'is_priority' => $priorityperiod, 'rooms' => $rooms,
            'camper' => $camper, 'success' => $success]);
    }

    public function read($i, $id, $success = null) {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        $family = \App\Family::find($this->getFamilyId($i, $id));
        $campers = \App\Thisyear_Camper::where('familyid', $family->id)->orderBy('birthdate')->get();

        return view('admin.rooms', ['buildings' => \App\Building::with('rooms')->get(),
            'campers' => $campers, 'success' => $success, 'readonly' => $readonly]);
    }

    public function write(Request $request, $id) {

        $campers = \App\Thisyear_Camper::where('familyid', $id)->get();

        foreach ($campers as $camper) {
            $ya = \App\Yearattending::find($camper->yearattendingid);
            $ya->roomid = $request->input($camper->id . '-roomid');
            $ya->is_setbyadmin = '1';
            $ya->save();
        }

        DB::statement('CALL generate_charges(getcurrentyear());');

        return $this->read('f', $id, 'Awwwwwwww yeahhhhhhhhh');
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}
