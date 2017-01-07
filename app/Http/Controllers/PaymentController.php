<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        return \App\Thisyear_Charge::where('familyid', \App\Camper::where('email', Auth::user()->email)->first()->family->id)->get();
    }
}
