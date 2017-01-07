<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function index()
    {
        return view('contactus', ['mailboxes' => \App\Contactbox::orderBy('id')->get()]);
    }

    public function store(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'Please check the CAPTCHA box and follow any additional instructions.',
        ];

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'mailbox' => 'required|exists:contactboxes,id',
            'message' => 'required|min:5',
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);

        // Multiple comma-delimited email addresses hack
        $users_temp = explode(',', DB::table('contactboxes')->where('id', $request->mailbox)->first()->emails);
        $users = [];
        foreach ($users_temp as $key => $ut) {
            $ua = [];
            $ua['email'] = $ut;
            $ua['name'] = 'MUUSA Planning Council';
            $users[$key] = (object)$ua;
        }

        Mail::to($users)->send(new ContactUs($request));

        return view('contactus', ['mailboxes' => \App\Contactbox::all()])
            ->with('success', 'Message sent! Please expect a response in 1-3 business days.');
    }
}
