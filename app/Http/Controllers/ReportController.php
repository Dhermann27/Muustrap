<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function campers($year = 0, $order = "name")
    {
        $year = $year == 0 ? \App\Year::where('is_current', '1')->first()->year : (int)$year;
        $years = \App\Byyear_Family::where('year', '>', '2008')->groupBy('year')->distinct()
            ->orderBy('year', 'DESC')->get();
        $families = \App\Byyear_Family::with('campers')->where('year', $year);
        if ($order == "name") {
            $families->orderBy('name');
        } else {
            $families->orderBy('created_at', 'DESC');
        }
        return view('reports.campers', ['title' => 'Registered Campers', 'years' => $years,
            'families' => $families->get(), 'thisyear' => $year]);
    }

    public function campersExport()
    {
        $year = \App\Year::where('is_current', '1')->first()->year;
        Excel::create('MUUSA_' . $year . '_Campers_' . Carbon::now()->toDateString(), function ($excel) {
            $excel->sheet('campers', function ($sheet) {
                $sheet->setOrientation('landscape');
                $sheet->with(\App\Thisyear_Camper::select('familyname', 'address1', 'address2', 'city', 'statecd',
                    'zipcd', 'country', 'pronounname', 'firstname', 'lastname', 'email', 'phonenbr', 'birthday', 'age',
                    'grade', 'programname', 'roommate', 'sponsor', 'churchname', 'churchcity', 'churchstatecd', 'days',
                    'room_number', 'buildingname')->orderBy('familyname')->orderBy('familyid')->orderBy('birthdate')->get());
            });
        })->export('xls');
    }

    public function chart()
    {
        $mergeddates = array();
        $dates = DB::select(DB::raw("SELECT ya.year AS theleft, RIGHT(DATE(ya.created_at),5) AS theright, DATE(ya.created_at) AS thedate, 
            (SELECT COUNT(*) FROM yearsattending yap WHERE yap.year=MAX(ya.year) AND DATE(yap.created_at) <= thedate) AS total
            FROM yearsattending ya, staticdates sd WHERE RIGHT(DATE(ya.created_at), 5)=RIGHT(DATE(sd.date), 5) AND ya.year>getcurrentyear()-7 
            GROUP BY DATE(ya.created_at) ORDER BY RIGHT(DATE(ya.created_at), 5)"));
        $summaries = DB::select(DB::raw("SELECT ya.year, COUNT(*) total, SUM(IF((SELECT COUNT(*) FROM yearsattending yap WHERE ya.year>yap.year AND c.id=yap.camperid)=0, 1, 0)) newcampers, 
            SUM(IF((SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-1=yap.year AND c.id=yap.camperid)=0 AND (SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-2=yap.year AND c.id=yap.camperid)=1,1,0)) oldcampers, 
            SUM(IF((SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-3<yap.year AND yap.year<ya.year AND c.id=yap.camperid)=0 AND (SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-3>=yap.year AND c.id=yap.camperid)>0,1,0)) voldcampers, 
            (SELECT COUNT(*) FROM yearsattending yap WHERE ya.year-1=yap.year AND (SELECT COUNT(*) FROM yearsattending yaq WHERE ya.year=yaq.year AND yap.camperid=yaq.camperid)=0) lostcampers 
            FROM campers c, yearsattending ya WHERE c.id=ya.camperid AND ya.year>getcurrentyear()-7 GROUP BY ya.year ORDER BY ya.year"));
        foreach ($dates as $date) {
            if (!array_has($mergeddates, $date->theright)) {
                $mergeddates[$date->theright] = array();
            }
            $mergeddates[$date->theright][$date->theleft] = $date->total;
        }
        return view('reports.chart', ['years' => \App\Year::where('year', '>', DB::raw("getcurrentyear()-7"))->get(),
            'summaries' => $summaries, 'dates' => $mergeddates]);
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
        $families = \App\Thisyear_Family::where(DB::raw("(SELECT COUNT(*) FROM byyear_families bf WHERE thisyear_families.id=bf.id AND bf.year!=getcurrentyear())"), 0)
            ->with('campers')->orderBy('name')->get();
        return view('reports.campers', ['title' => 'First-time Campers', 'families' => $families,
            'years' => ['2008']]);
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

    public function payments($year = 0)
    {
        $year = $year == 0 ? \App\Year::where('is_current', '1')->first()->year : (int)$year;
        $years = \App\Byyear_Charge::where('year', '>', '2008')->groupBy('year')->distinct()
            ->orderBy('year', 'DESC')->get();
        return view('reports.payments', ['charges' => \App\Byyear_Charge::where('amount', '!=', '0.0')
            ->where('year', $year)->with('camper')->with('family')->get(), 'years' => $years]);
    }

    public function paymentsExport()
    {
        $year = \App\Year::where('is_current', '1')->first()->year;
        Excel::create('MUUSA_' . $year . '_Ledger_' . Carbon::now()->toDateString(), function ($excel) {
            $excel->sheet('payments', function ($sheet) {
                $sheet->setOrientation('landscape');
                $sheet->with(\App\Thisyear_Charge::select('families.name', 'campers.firstname', 'campers.lastname',
                    'thisyear_charges.amount', 'thisyear_charges.chargetypename', 'thisyear_charges.timestamp')
                    ->join('campers', 'thisyear_charges.camperid', 'campers.id')
                    ->join('families', 'campers.familyid', 'families.id')->orderBy('families.name')
                    ->orderBy('thisyear_charges.familyid')->orderBy('thisyear_charges.timestamp')->get());
            });
        })->export('xls');
    }

    public function programs()
    {
        return view('reports.programs', ['programs' => \App\Program::where('name', '!=', 'Adult')
            ->with('participants.parents')->orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get()]);
    }

    public function rates()
    {
        return view('reports.rates', ['years' => \App\Year::where('year', '>', 2014)->get(),
            'buildings' => \App\Building::all(), 'rates' => \App\Rate::all(),
            'programs' => \App\Program::orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get()]);
    }

    public function rooms($year = 0)
    {
        $year = $year == 0 ? \App\Year::where('is_current', '1')->first()->year : (int)$year;
        $years = \App\Byyear_Camper::where('year', '>', '2008')->groupBy('year')->distinct()
            ->orderBy('year', 'DESC')->get();
        $campers = \App\Byyear_Camper::where('year', $year)->whereNotNull('roomid')
            ->orderBy('room_number')->orderBy('familyid')->orderBy('birthdate')->get();
        return view('reports.rooms', ['campers' => $campers, 'buildings' => \App\Building::all(),
            'years' => $years]);
    }

    public function roomsExport()
    {
        $year = \App\Year::where('is_current', '1')->first()->year;
        Excel::create('MUUSA_' . $year . '_Rooms_' . Carbon::now()->toDateString(), function ($excel) {
            $buildings = \App\Thisyear_Camper::whereNotNull('roomid')->groupBy('buildingid')->distinct()->get();
            foreach ($buildings as $building) {
                $excel->sheet($building->buildingname, function ($sheet) use ($building) {
                    $sheet->setOrientation('landscape');
                    $sheet->with(\App\Thisyear_Camper::select('room_number', 'firstname', 'lastname', 'address1',
                        'address2', 'city', 'statecd', 'zipcd', 'age')->where('buildingid', $building->buildingid)
                        ->orderBy('room_number')->orderBy('familyid')->orderBy('birthdate')->get());
                });
            }
        })->export('xls');
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
        DB::raw('CALL workshops()');
        return view('reports.workshops', ['timeslots' => \App\Timeslot::with('workshops.choices.yearattending.camper')->get()]);

    }
}
