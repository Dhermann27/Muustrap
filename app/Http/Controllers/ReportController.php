<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function campers() {
        $years = \App\Byyear_Family::with('campers')->where('year', '>', DB::raw('getcurrentyear()-8'))
            ->orderBy('year')->orderBy('name')->get()->groupBy('year');
        return view('reports.campers', ['years' => $years]);
    }

    public function rooms() {
        $years = \App\Byyear_Camper::where('year', '>', DB::raw('getcurrentyear()-8'))
            ->whereNotNull('roomid')->orderBy('year')->orderBy('room_number')->get()->groupBy('year');
        return view('reports.rooms', ['years' => $years, 'buildings' => \App\Building::all()]);
    }
}
