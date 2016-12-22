<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class ContactController extends Controller
{

    public function index()
    {
        return view('contactus', ['mailboxes' => \App\Contactbox::all()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'id' => 'required|unique:contactboxes',
            'message' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }
}
