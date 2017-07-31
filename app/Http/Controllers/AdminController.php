<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{

    public function distlistStore(Request $request)
    {
        $programs = \App\Program::orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get();

        $rows = \App\Byyear_Camper::select('familyname', 'address1', 'address2', 'city', 'statecd',
            'zipcd', 'country', 'pronounname', 'firstname', 'lastname', 'email', 'phonenbr', 'birthday', 'age',
            'grade', 'programname', 'roommate', 'sponsor', 'churchname', 'churchcity', 'churchstatecd', 'days',
            'room_number', 'buildingname');
        if ($request->input("campers") == "reg") {
            $rows->where('year', DB::raw('getcurrentyear()'));
        } elseif ($request->input("campers") == "oneyear") {
            $rows->where('year', DB::raw('getcurrentyear()-1'));
        } elseif ($request->input("campers") == "threeyears") {
            $rows->where('year', '>', DB::raw('getcurrentyear()-3'));
        }

        if ($request->input("email") == "1") {
            $rows->where('email', '!=', '\'\'');
        }
        if ($request->input("ecomm") == "1") {
            $rows->where('is_ecomm', '1');
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
            $rows->whereIn(DB::raw('getprogramidbycamperid(id, year)'), $programids);
        }


        $year = \App\Year::where('is_current', '1')->first()->year;
        Excel::create('MUUSA_' . $year . '_Distlist_' . Carbon::now()->toDateString(), function ($excel) use ($rows) {
            $excel->sheet('campers', function ($sheet) use ($rows) {
                $sheet->with($rows->orderBy('familyname')->orderBy('familyid')->orderBy('birthdate')->get());
            });
        })->export('csv');
    }

    public function distlistIndex()
    {
        return view('admin.distlist', ['programs' => \App\Program::orderBy('age_min', 'desc')
            ->orderBy('grade_min', 'desc')->get(), 'request' => new Request()]);
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

        return $this->roleIndex();
    }

    public function roleIndex()
    {
        return view('admin.roles', ['roles' => \App\Role::with('users.camper')->get()]);
    }

    public function positionStore(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $matches = array();
            if (preg_match('/(\d+)-(delete|name|compensationlevelid)/', $key, $matches)) {
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
        foreach (\App\Program::all() as $program) {
            if ($request->input($program->id . "-position") != '') {
                $position = new \App\Staffposition();
                $position->name = $request->input($program->id . "-position");
                $position->compensationlevelid = $request->input($program->id . "-compensationlevel");
                $position->programid = $program->id;
                $position->start_year = '1901';
                $position->end_year = '2100';
                $position->save();
            }
        }

        return $this->positionIndex('You created those positions like a <i>pro</i>.');
    }

    public function positionIndex($success = null)
    {
        $programs = \App\Program::with('staffpositions')
            ->orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get();
        return view('admin.positions', ['programs' => $programs,
            'levels' => \App\Compensationlevel::all(), 'success' => $success]);
    }

}
