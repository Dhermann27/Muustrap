<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function campers()
    {
        $years = \App\Byyear_Family::with('campers')->where('year', '>', DB::raw('getcurrentyear()-8'))
            ->orderBy('year')->orderBy('name')->get()->groupBy('year');
        return view('reports.campers', ['years' => $years]);
    }

    public function chart()
    {
        return view('reports.chart', ['dates' => \App\Staticdate::all(),
            \App\Yearattending::select(DB::raw('DATE_FORMAT(created_at, \'%y%m%d\')'))]);
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

    public function payments()
    {
        return view('reports.payments', ['years' => \App\Byyear_Charge::where('amount', '!=', '0.0')
            ->where('year', '>', DB::raw('getcurrentyear()-5'))->with('camper')->with('family')->get()->groupBy('year')
        ]);
    }

    public function rates()
    {
        $year = \App\Year::where('is_current', 1)->first()->year;
        return view('reports.rates', ['buildings' => \App\Building::all(),
            'programs' => \App\Program::where('start_year', '<=', $year)->where('end_year', '>=', $year)
                ->orderBy('age_min', 'desc')->orderBy('grade_min', 'desc')->get(),
            'rates' => \App\Rate::where('start_year', '<=', $year)->where('end_year', '>=', $year)->get()]);
    }

    public function rooms()
    {
        $years = \App\Byyear_Camper::where('year', '>', DB::raw('getcurrentyear()-5'))
            ->whereNotNull('roomid')->orderBy('year')->orderBy('room_number')->get()->groupBy('year');
        return view('reports.rooms', ['years' => $years, 'buildings' => \App\Building::all()]);
    }

    public function workshops()
    {
        return view('reports.workshops', ['timeslots' => \App\Timeslot::with('workshops.choices.yearattending.camper')->get()]);

    }
}
