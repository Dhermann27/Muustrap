<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolsController extends Controller
{


    public function positionStore(Request $request)
    {
        foreach (\App\Program::all() as $program) {
            if ($request->input($program->id . "-camperid") != '' && $request->input($program->id . "-staffpositionid") != '') {
                $ya = \App\Yearattending::where('camperid', $request->input($program->id . "-camperid"))->where('year', DB::raw('getcurrentyear()'))->first();
                if(!empty($ya)) {
                    $assignment = new \App\Yearattending__Staff();
                    $assignment->yearattendingid = $ya->id;
                    $assignment->staffpositionid = $request->input($program->id . "-staffpositionid");
                    $assignment->is_eaf_paid = 1;
                    $assignment->save();
                } else {
                    $assignment = new \App\Camper__Staff();
                    $assignment->camperid = $request->input($program->id . "-camperid");
                    $assignment->staffpositionid = $request->input($program->id . "-staffpositionid");
                    $assignment->save();
                }
            }
        }
        DB::statement('CALL generate_charges();');

        return $this->positionIndex('Assigned. Suckers! No backsies.');
    }

    public function positionIndex($success = null)
    {
        $year = \App\Year::where('is_current', '1')->first()->year;
        return view('tools.positions', ['programs' => \App\Program::where('start_year', '<=', $year)
            ->where('end_year', '>=', $year)->orderBy('age_min', 'desc')->with('staffpositions.compensationlevel')->
            with('assignments')->orderBy('grade_min', 'desc')->get(),
            'year' => $year, 'success' => $success]);
    }
}
