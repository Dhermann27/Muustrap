<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolsController extends Controller
{

    public function positionStore(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $matches = array();
            if (preg_match('/(\d+)-(\d+)-delete/', $key, $matches)) {
                $ya = \App\Thisyear_Camper::find($matches[1]);
                if ($ya) {
                    $assignment = \App\Yearattending__Staff::where('yearattendingid', $ya->yearattendingid)->where('staffpositionid', $matches[2]);
                } else {
                    $assignment = \App\Camper__Staff::where('camperid', $matches[1])->where('staffpositionid', $matches[2]);
                }
                if ($value == 'on') {
                    $assignment->delete();
                }
            }
        }
        foreach (\App\Program::all() as $program) {
            if ($request->input($program->id . "-camperid") != '' && $request->input($program->id . "-staffpositionid") != '') {
                $ya = \App\Thisyear_Camper::find($request->input($program->id . "-camperid"));
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
        DB::statement('CALL generate_charges(getcurrentyear());');

        return $this->positionIndex('Assigned. Suckers! No backsies.');
    }

    public function positionIndex($success = null)
    {
        $year = \App\Year::where('is_current', '1')->first()->year;
        return view('tools.positions', ['programs' => \App\Program::with(['staffpositions' => function ($query) use ($year) {
            $query->where('start_year', '<=', $year)->where('end_year', '>=', $year);
        }])->with('assignments')
            ->orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get(),
            'year' => $year, 'success' => $success]);
    }

    public function nametags()
    {
        return view('tools.nametags', ['campers' => \App\Thisyear_Camper::orderBy('familyid')
            ->orderBy('birthdate')->get()]);
    }


    public function programStore(Request $request)
    {
        foreach (\App\Program::all() as $program) {
            if ($request->input($program->id . "-blurb") != '<p><br></p>') {
                $program->blurb = $request->input($program->id . "-blurb");
                $program->letter = $request->input($program->id . "-letter");
                if ($request->input($program->id . "-link") != '') {
                    $program->link = $request->input($program->id . "-link");
                    $client = new GuzzleHttp\Client();
                    $res = $client->request('GET', env('GOOGLE_SCRIPT') . $program->link);
                    if ($res->getStatusCode() == '200') {
                        $program->form = $res->getBody();
                    } else {
                        $program->form = "Error: " . $res->getStatusCode();
                    }
                }
                $program->save();
            }
        }

        return $this->programIndex('Psssssh, great job updating your program. Yeah, you\'re a big deal now, I\'m sure. Whatever.');
    }

    public function programIndex($success = null)
    {
        $year = \App\Year::where('is_current', '1')->first()->year;
        return view('tools.programs', ['programs' => \App\Program::orderBy('age_min', 'desc')
            ->orderBy('grade_min', 'desc')->get(), 'year' => $year, 'success' => $success]);
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

    public function workshopIndex($success = null)
    {
        return view('tools.workshops', ['timeslots' => \App\Timeslot::all(),
            'rooms' => \App\Room::where('is_workshop', '1')->get(), 'success' => $success]);
    }
}
