<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{


    public function positionStore(Request $request)
    {
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
        return view('admin.positions', ['programs' => \App\Program::where('start_year', '<=', $year)
            ->where('end_year', '>=', $year)->with('staffpositions.compensationlevel')->orderBy('age_min', 'desc')
            ->orderBy('grade_min', 'desc')->get(),
            'year' => $year, 'levels' => \App\Compensationlevel::all(), 'success' => $success]);
    }
}