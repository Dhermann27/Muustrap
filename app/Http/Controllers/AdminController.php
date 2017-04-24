<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function roleStore(Request $request)
    {
        $error = "";
        foreach (\App\Role::all() as $role) {
            if ($request->input($role->id . "-camperid") != '') {
                $user = \App\Camper::find($request->input($role->id . "-camperid"));
                if ($user->user()->first() !== null) {
                    $user->user()->first()->roles()->attach($role->id);
                } else {
                    $error .= $user->firstname . " " . $user->lastname . " has not yet regisetered on muusa.org.<br />";
                }
            }
        }

        return $this->roleIndex('Real artists ship.', $error);
    }

    public function roleIndex($success = null, $error = null)
    {
        return view('admin.roles', ['roles' => \App\Role::with('users.camper')->get(),
            'success' => $success, 'error' => $error]);
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
        $year = \App\Year::where('is_current', '1')->first()->year;
        $programs = \App\Program::with(['staffpositions' => function ($query) use ($year) {
            $query->where('start_year', '<=', $year)->where('end_year', '>=', $year);
        }])->orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get();
        return view('admin.positions', ['programs' => $programs, 'year' => $year,
            'levels' => \App\Compensationlevel::all(), 'success' => $success]);
    }

}
