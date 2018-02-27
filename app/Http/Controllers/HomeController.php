<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function apc()
    {
        return \App\Thisyear_Staff::where('pctype', '1')->get();
    }

    public function ec() {
        return \App\Thisyear_Staff::where('pctype', '2')->get();
    }

    public function pc() {
        return \App\Thisyear_Staff::where('pctype', '>=', '1')->get();
    }

    public function programs() {
        return \App\Thisyear_Staff::where('pctype', '3')->get();
    }

    public function registered() {
        return Auth::check() && \App\Thisyear_Camper::where('email', Auth::user()->email)->first();
    }

    public function year()
    {
        return \App\Year::where('is_current', '1')->first();
    }
}
