<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function store(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'Please check the CAPTCHA box and follow any additional instructions.',
        ];

        $this->validate($request, [
            'name' => 'max:255',
            'email' => 'email|max:255',
            'mailbox' => 'required|exists:contactboxes,id',
            'message' => 'required|min:5',
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);

        $users = explode(',', DB::table('contactboxes')->where('id', $request->mailbox)->first()->emails);

        Mail::to($users)->send(new ContactUs($request));

        return $this->index('Message sent! Please expect a response in 1-3 business days.');
    }

    public function index($success = null)
    {
        if (Auth::check()) {
            $camper = \App\Camper::where('email', Auth::user()->email)->first();
        }
        return view('contactus', ['mailboxes' => \App\Contactbox::orderBy('id')->get(),
            'camper' => $camper, 'success' => $success]);
    }
}
