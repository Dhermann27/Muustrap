<?php

namespace App\Http\Controllers;

use App\Mail\ArtFair;
use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function contactStore(Request $request)
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

        $users = DB::table('contactboxes')->find($request->mailbox)->emails;

        Mail::to($users)->send(new ContactUs($request));

        return $this->contactIndex('Message sent! Please expect a response in 1-3 business days.');
    }

    public function contactIndex($success = null)
    {
        $camper = null;
        if (Auth::check()) {
            $camper = \App\Camper::where('email', Auth::user()->email)->first();
        }
        return view('contactus', ['mailboxes' => \App\Contactbox::orderBy('id')->get(),
            'camper' => $camper, 'success' => $success]);
    }

    public function artfairStore(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'Please check the CAPTCHA box and follow any additional instructions.',
        ];

        $this->validate($request, [
            'message' => 'required|min:5',
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);

        Mail::to(env('ARTFAIR_EMAIL'))->send(new ArtFair($request, \App\Thisyear_Camper::where('email', Auth::user()->email)->first()));

        return $this->artfairIndex('Message sent! Replies will be sent to all applicants by May 1st.');
    }

    public function artfairIndex($success = null)
    {
        $camper = null;
        if (Auth::check()) {
            $camper = \App\Thisyear_Camper::where('email', Auth::user()->email)->first();
        }
        return view('artfair', ['camper' => $camper, 'success' => $success]);
    }
}
