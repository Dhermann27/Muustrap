<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function campers()
    {
        $years = \App\Byyear_Family::with('campers')->where('year', '>', DB::raw('getcurrentyear()-5'))
            ->orderBy('year')->orderBy('name')->get()->groupBy('year');
        return view('reports.campers', ['title' => 'Registered Campers', 'years' => $years]);
    }

    public function chart()
    {
        $mergeddates = array();
        $dates = DB::select(DB::raw("SELECT LEFT(DATE(ya.created_at),4) AS theleft, RIGHT(DATE(ya.created_at),5) AS theright, DATE(ya.created_at)AS thedate, 
            (SELECT COUNT(*) FROM yearsattending yap WHERE yap.year=MAX(ya.year) AND DATE(yap.created_at) <= thedate) AS total
            FROM yearsattending ya WHERE ya.year>getcurrentyear()-6
            GROUP BY DATE(ya.created_at) ORDER BY RIGHT(DATE(ya.created_at), 5)"));
        $summaries = DB::select(DB::raw("SELECT ya.year, 
            COUNT(*) total, SUM(IF((SELECT COUNT(*) FROM yearsattending yap WHERE ya.year>yap.year AND c.id=yap.camperid)=0, 1, 0)) newcampers, 
            SUM(IF((SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-1=yap.year AND c.id=yap.camperid)=0 AND (SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-2=yap.year AND c.id=yap.camperid)=1,1,0)) oldcampers, 
            SUM(IF((SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-3<yap.year AND yap.year<ya.year AND c.id=yap.camperid)=0 AND (SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-3>=yap.year AND c.id=yap.camperid)>0,1,0)) voldcampers, 
            (SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-1=yap.year AND (SELECT COUNT(*) FROM yearsattending yaq WHERE ya.year=yaq.year AND yap.camperid=yaq.camperid)=0) lostcampers 
            FROM campers c, yearsattending ya WHERE c.id=ya.camperid AND ya.year>getcurrentyear()-6 GROUP BY ya.year ORDER BY ya.year"));
        foreach ($dates as $date) {
            if (!array_has($mergeddates, $date->theright)) {
                $mergeddates[$date->theright] = array();
            }
            $mergeddates[$date->theright][$date->theleft] = $date->total;
        }
        return view('reports.chart', ['years' => \App\Year::where('year', '>', DB::raw("getcurrentyear()-6"))->pluck('year'), 'summaries' => $summaries,
            'dates' => $mergeddates]);
    }

    public function depositsMark($id)
    {
        \App\Charge::where('chargetypeid', $id)->where('deposited_date', null)
            ->update(['deposited_date' => Carbon::now()->toDateString()]);
        return $this->deposits();
    }

    public function deposits()
    {
        $chargetypes = \App\Chargetype::where('is_deposited', '1')->get();
        return view('reports.deposits', ['chargetypes' => $chargetypes,
            'charges' => \App\Thisyear_Charge::whereIn('chargetypeid', $chargetypes->pluck('id')->toArray())
                ->orderBy('deposited_date')->orderBy('timestamp', 'desc')->get()->groupBy('deposited_date')
        ]);
    }

    public function firsttime()
    {
        $years = ['1' => \App\Thisyear_Family::where(DB::raw("(SELECT COUNT(*) FROM byyear_families bf WHERE thisyear_families.id=bf.id AND bf.year!=getcurrentyear())"), 0)
            ->with('campers')->orderBy('name')->get()];
        return view('reports.campers', ['title' => 'First-time Campers', 'years' => $years]);
    }

    public function outstandingMark(Request $request, $id)
    {
        $charge = new \App\Charge();
        $charge->camperid = $id;
        $charge->amount = $request->input('amount');
        $charge->memo = $request->input('memo');
        $charge->chargetypeid = $request->input('chargetypeid');
        $charge->timestamp = Carbon::now()->toDateString();
        $charge->year = DB::raw('getcurrentyear()');
        $charge->save();

        return $this->outstanding('This payment was totally ignored, but the green message still seems congratulatory.');
    }

    public function outstanding($success = null)
    {
        $chargetypes = \App\Chargetype::where('is_shown', '1')->orderBy('name')->get();
        return view('reports.outstanding', ['chargetypes' => $chargetypes,
            'readonly' => \Entrust::can('read') && !\Entrust::can('write'),
            'charges' => \App\Thisyear_Charge::select(DB::raw('MAX(`familyid`) AS familyid'), DB::raw('MAX(`camperid`) AS camperid'), DB::raw('SUM(`amount`) as amount'))
                ->groupBy('familyid')->having(DB::raw('SUM(`amount`)'), '!=', '0.0')
                ->join('families', 'families.id', 'thisyear_charges.familyid')->orderBy('families.name')->get()
        ]);
    }

    public function payments()
    {
        return view('reports.payments', ['years' => \App\Byyear_Charge::where('amount', '!=', '0.0')
            ->where('year', '>', DB::raw('getcurrentyear()-5'))->with('camper')->with('family')->get()->groupBy('year')
        ]);
    }

    public function programs()
    {
        $year = \App\Year::where('is_current', 1)->first()->year;
        return view('reports.programs', ['programs' => \App\Program::where('name', '!=', 'Adult')
            ->with('participants')->orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get()]);
    }

    public function rates()
    {
        return view('reports.rates', ['years' => \App\Year::where('year', '>', 2014)->get(),
            'buildings' => \App\Building::all(), 'rates' => \App\Rate::all(),
            'programs' => \App\Program::orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get()]);
    }

    public function rooms()
    {
        $years = \App\Byyear_Camper::where('year', '>', DB::raw('getcurrentyear()-5'))
            ->whereNotNull('roomid')->orderBy('year')->orderBy('room_number')->get()->groupBy('year');
        return view('reports.rooms', ['years' => $years, 'buildings' => \App\Building::all()]);
    }

    public function roommates()
    {
        return view('reports.roommates', ['campers' => \App\Thisyear_Camper::where('roommate', '!=', '')
            ->orderBy('lastname')->orderBy('firstname')->get()]);
    }

    public function states()
    {
        $years = \App\Byyear_Camper::where('year', '>', DB::raw('getcurrentyear()-8'))
            ->select("year", "churchstatecd AS code", DB::raw("COUNT(*) AS total"))
            ->where("churchid", "!=", "2084")->groupBy("year", "churchstatecd")
            ->orderBy("year")->orderBy("total", "desc")->get()->groupBy("year");
        $churches = \App\Byyear_Camper::where('year', '>', DB::raw('getcurrentyear()-8'))
            ->select("year", "churchstatecd", "churchname", "churchcity", DB::raw("COUNT(*) AS total"))
            ->where("churchid", "!=", "2084")->groupBy("year", "churchid")
            ->orderBy("total", "desc")->get();
        return view('reports.states', ['years' => $years, 'churches' => $churches]);
    }

    public function volunteers()
    {
        $years = \App\Byyear_Camper::where("year", ">", DB::raw("getcurrentyear()-4"))
            ->join("yearattending__volunteer", "byyear_campers.yearattendingid", "yearattending__volunteer.yearattendingid")
            ->join("volunteerpositions", "yearattending__volunteer.volunteerpositionid", "volunteerpositions.id")
            ->orderBy("byyear_campers.year")->orderBy("byyear_campers.lastname")->orderBy("byyear_campers.firstname")->get()
            ->groupBy("year");
        return view('reports.volunteers', ['years' => $years, 'positions' => \App\Volunteerposition::orderBy("name")->get()]);
    }

    public function workshops()
    {
        DB::raw('CALL enroll_workshops()');
        return view('reports.workshops', ['timeslots' => \App\Timeslot::with('workshops.choices.yearattending.camper')->get()]);

    }
}
