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
                if (!empty($ya)) {
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
            ->where('end_year', '>=', $year)->orderBy('age_min', 'desc')->with('staffpositions.compensationlevel')
            ->with('assignments')->orderBy('grade_min', 'desc')->get(),
            'year' => $year, 'success' => $success]);
    }

    public function workshopStore(Request $request)
    {
        foreach (\App\Timeslot::all() as $timeslot) {
            if ($request->input($timeslot->id . "-name") != '') {
                $workshop = new \App\Workshop();
                $workshop->name = $request->input($timeslot->id . "-name");
                $workshop->led_by = $request->input($timeslot->id . "-led_by");
                $workshop->roomid = $request->input($timeslot->id . "-roomid");
                $workshop->timeslotid = $timeslot->id;
                $workshop->order = $request->input($timeslot->id . "-order");
                $workshop->blurb = $request->input($timeslot->id . "-blurb");
                $workshop->m = $request->input($timeslot->id . "-m") == 'on' ? '1' : '0';
                $workshop->t = $request->input($timeslot->id . "-t") == 'on' ? '1' : '0';
                $workshop->w = $request->input($timeslot->id . "-w") == 'on' ? '1' : '0';
                $workshop->th = $request->input($timeslot->id . "-th") == 'on' ? '1' : '0';
                $workshop->f = $request->input($timeslot->id . "-f") == 'on' ? '1' : '0';
                $workshop->enrolled = 0;
                $workshop->capacity = $request->input($timeslot->id . "-capacity");
                $workshop->fee = 0;
                $workshop->save();
            }
        }

        return $this->workshopIndex('That sounds interesting; think I\'ll sign up for that one.');
    }

    public
    function workshopIndex($success = null)
    {
        return view('tools.workshops', ['timeslots' => \App\Timeslot::all(),
            'rooms' => \App\Room::where('is_workshop', '1')->get(), 'success' => $success]);
    }
}
