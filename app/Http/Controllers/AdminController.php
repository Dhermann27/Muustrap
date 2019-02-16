<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;

class AdminController extends Controller
{

    public function distlistStore(Request $request)
    {
        $programs = \App\Program::orderBy('order')->get();

        $rows = \App\Byyear_Camper::select('familyname', 'familytitle', 'address1', 'address2', 'city', 'statecd',
            'zipcd', 'country', 'pronounname', 'firstname', 'lastname', DB::raw('MAX(email)'), 'phonenbr', 'birthday', 'age',
            'programname', 'roommate', 'sponsor', 'churchname', 'churchcity', 'churchstatecd', 'days', 'room_number',
            'buildingname');
        if ($request->input("campers") == "reg") {
            $rows->where('year', DB::raw('getcurrentyear()'));
        } elseif ($request->input("campers") == "unp") {
            $rows->where('byyear_campers.year', DB::raw('getcurrentyear()'));
            $rows->where(DB::raw('(SELECT SUM(amount) FROM byyear_charges 
                    WHERE byyear_campers.familyid=byyear_charges.familyid AND 
                          byyear_campers.year=byyear_charges.year AND
                         (chargetypeid=1003 OR amount<0) GROUP BY byyear_campers.familyid)'), '>', 0);
        } elseif ($request->input("campers") == "uns") {
            $rows->where('byyear_campers.year', DB::raw('getcurrentyear()'));
            $rows->whereRaw('byyear_campers.familyid IN (SELECT familyid FROM byyear_campers bcp
                    LEFT JOIN medicalresponses m ON bcp.yearattendingid=m.yearattendingid 
                    WHERE m.id IS NULL AND bcp.age<18 GROUP BY bcp.familyid)');
        } elseif ($request->input("campers") == "oneyear") {
            $rows->where('year', DB::raw('getcurrentyear()-1'));
        } elseif ($request->input("campers") == "lost") {
            $rows->where('year', DB::raw('getcurrentyear()-1'));
            $rows->where(DB::raw('(SELECT COUNT(*) FROM thisyear_campers WHERE byyear_campers.id=thisyear_campers.id)'), 0);
        } elseif ($request->input("campers") == "loster") {
            $rows->where('year', DB::raw('getcurrentyear()-3'));
            $rows->where(DB::raw('(SELECT COUNT(*) FROM thisyear_campers WHERE byyear_campers.id=thisyear_campers.id)'), 0);
        } elseif ($request->input("campers") == "threeyears") {
            $rows->where('year', '>', DB::raw('getcurrentyear()-3'));
        }

        if ($request->input("email") == "1") {
            $rows->where('email', '!=', '\'\'');
        }
        if ($request->input("ecomm") != '-1') {
            $rows->where('is_ecomm', $request->input("ecomm"));
        }

        if ($request->input("current") == "1") {
            $rows->where('is_address_current', '1');
        }

        $programids = array();
        foreach ($programs as $program) {
            if ($request->input("program-" . $program->id) == "on") {
                array_push($programids, $program->id);
            }
        }
        if (count($programids) > 0) {
            $rows->whereIn('programid', $programids);
        }

        $rows->groupBy("byyear_campers." . $request->input("groupby"));

        $counter = $rows->count();
        if ($counter > 0) {
            $year = \App\Year::where('is_current', '1')->first()->year;
            Excel::create('MUUSA_' . $year . '_Distlist_' . Carbon::now()->toDateString(), function ($excel) use ($rows) {
                $excel->sheet('campers', function ($sheet) use ($rows) {
                    $sheet->with($rows->orderBy('familyname')->orderBy('familyid')->orderBy('birthdate')->get());
                });
            })->export('csv');
        } else {
            $request->session()->flash('warning', 'No campers found.');
            return redirect()->action('AdminController@distlistIndex', ['request' => $request]);
        }
    }

    public function distlistIndex($request = null)
    {
        return view('admin.distlist', ['programs' => \App\Program::orderBy('order')->get(),
            'request' => $request ? $request : new Request()]);
    }

    public function massAssignStore(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (preg_match('/(\d+)-roomid/', $key, $matches)) {
                $ya = \App\Yearattending::findOrFail($matches[1]);
                $ya->roomid = $value;
                $ya->save();
            }
        }
        return $request->input('familyid');
    }


    public function massAssignIndex()
    {
        $families = \App\Thisyear_Family::orderBy('name')->get();
        $campers = \App\Thisyear_Camper::orderBy('birthdate')->get()->groupBy('familyid');

        $buildings = \App\Building::with('rooms.occupants')->get();
        return view('reports.campers', ['title' => 'Rooms Assignment Function', 'buildings' => $buildings,
            'families' => $families, 'campers' => $campers]);
    }

    public function masterStore(Request $request)
    {
        $thisyear = null;
        foreach ($request->all() as $key => $value) {
            if (preg_match('/(\d+)-(start_date|start_open|is_current|is_live|is_crunch|is_accept_paypal|is_calendar|is_room_select|is_workshop_proposal|is_artfair|is_coffeehouse)/', $key, $matches)) {
                if ($thisyear == null) {
                    $thisyear = \App\Year::findOrFail($matches[1]);
                }
                if ($matches[2] == "is_current" && $value == 'on') {
                    $lastyear = \App\Year::where('is_current', '1')->first();
                    $lastyear->is_current = 0;
                    $lastyear->save();

                    $newyear = \App\Year::findOrFail($matches[1]);
                    $newyear->is_current = 1;
                    $newyear->save();

                    $thisyear = null;
                    break;
                }
                $thisyear->{$matches[2]} = $value;
            }
        }
        if ($thisyear != null) {
            $thisyear->save();
        }


        $request->session()->flash('success', 'That\'s Tron. He fights for the Users.');

        return redirect()->action('AdminController@masterIndex');
    }

    public function masterIndex()
    {
        return view('admin.master', ['years' => \App\Year::all()]);
    }

    public function roleStore(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $matches = array();
            if (preg_match('/(\d+)-(\d+)-delete/', $key, $matches)) {
                if ($value == 'on') {
                    DB::table('role_user')->where('role_id', $matches[2])->where('user_id', $matches[1])->delete();
                }
            }
        }

        foreach (\App\Role::all() as $role) {
            if ($request->input($role->id . "-camperid") != '') {
                $user = \App\Camper::find($request->input($role->id . "-camperid"));
                if ($user->user()->first() !== null) {
                    $user->user()->first()->roles()->attach($role->id);
                } else {
                    $request->session()->flash('error',
                        $user->firstname . " " . $user->lastname . " has not yet regisetered on muusa.org.<br />");
                }
            }
        }
        $request->session()->flash('success', 'Real artists ship.');

        return redirect()->action('AdminController@roleIndex');
    }

    public function roleIndex()
    {
        return view('admin.roles', ['roles' => \App\Role::with('users.camper')->get()]);
    }

    public function positionStore(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $matches = array();
            if (preg_match('/(\d+)-(delete|programid|name|compensationlevelid)/', $key, $matches)) {
                $position = \App\Staffposition::findOrFail($matches[1]);
                if ($matches[2] == 'delete') {
                    if ($value == 'on') {
                        \App\Yearattending__Staff::where('staffpositionid', $key)->delete();

                        $position->end_year = DB::raw('getcurrentyear()-1');
                        $position->save();
                    }
                } else {
                    $position->{$matches[2]} = $value;
                    $position->save();
                }
            }
        }

        if ($request->input('name') != '') {
            $position = new \App\Staffposition();
            $position->programid = $request->input('programid');
            $position->name = $request->input('name');
            $position->compensationlevelid = $request->input('compensationlevelid');
            $position->start_year = '1901';
            $position->end_year = '2100';
            $position->save();
        }

        $request->session()->flash('success', 'You created those positions like a <i>pro</i>.');

        return redirect()->action('AdminController@positionIndex');
    }

    public function positionIndex()
    {
        $programs = \App\Program::with('staffpositions')->orderBy('order')->get();
        return view('admin.positions', ['programs' => $programs,
            'levels' => \App\Compensationlevel::all()]);
    }

}
