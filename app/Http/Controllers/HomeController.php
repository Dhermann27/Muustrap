<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function campcost()
    {
        return view('campcost', ['background' => '/images/calculator.jpg', 'rates' => DB::table('rates')
            ->join('years', function ($join) {
                $join->on('rates.start_year', '<=', 'years.year')->on('rates.end_year', '>', 'years.year');
            })->join('programs', 'programs.id', 'rates.programid')
            ->whereIn('buildingid', ['1000', '1007', '1017'])->where('years.is_current', '1')
            ->orderBy('name')->orderBy('min_occupancy')->orderBy('max_occupancy')->get()]);
    }

    public function housing()
    {
        return view('housing', ['buildings' => \App\Building::whereNotNull('blurb')->get(), 'background' => '/images/housing.jpg']);
    }

    public function programs()
    {
        return view('programs', ['programs' => \App\Program::whereNotNull('blurb')->orderBy('order')->get(), 'background' => '/images/programs.jpg']);
    }

    public function registration()
    {
        return view('registration');
    }

    public function scholarship()
    {
        return view('scholarship', ['background' => '/images/scholarship.jpg']);
    }

    public function themespeaker()
    {
        return view('themespeaker', [ 'background' => '/images/biographies.jpg']);
    }
}
