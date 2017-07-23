<?php

namespace App\Http\Controllers;

use App\Mail\ArtFair;
use App\Mail\ContactUs;
use App\Mail\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $users = \App\Contactbox::findOrFail($request->mailbox)->emails;

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

    public function proposalStore(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'Please check the CAPTCHA box and follow any additional instructions.',
        ];

        $this->validate($request, [
            'type' => 'required|in:Workshop,Vespers,Special Event',
            'name' => 'required|min:5',
            'message' => 'required|min:5|max:255',
            'qualifications' => 'required|min:5',
            'atmuusa' => 'required',
            'atelse' => 'required',
            'ages' => 'required|in:Adults,All Ages,Young Adults,Senior High,Junior High',
            'days' => 'required|between:1,5',
            'timeslot' => 'required|exists:timeslots,name',
            'room' => 'required',
            'equip' => 'required',
            'fee' => 'required',
            'capacity' => 'required',
            'waive' => 'required|in:No,Yes',
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);

        $camper = \App\Camper::where('email', Auth::user()->email)->first();
        Mail::to(env('PROPOSAL_EMAIL'))->send(new Proposal($request, $camper));

        return $this->proposalIndex($camper, 'Message sent! You will be contact by a member of the Adult Programming Committee.');
    }

    public function proposalIndex($camper = null, $success = null)
    {
        if ($camper == null) {
            $camper = \App\Camper::where('email', Auth::user()->email)->first();
        }
        return view('proposal', ['camper' => $camper, 'timeslots' => \App\Timeslot::all(), 'success' => $success]);
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

    public function museStore(Request $request)
    {
        $messages = [
            'date.regex' => 'Please enter the eight-digit date in 2016-12-31 format.',
            'g-recaptcha-response.required' => 'Please check the CAPTCHA box and follow any additional instructions.',
        ];

        $this->validate($request, [
            'date' => 'regex:/^\d{4}-\d{2}-\d{2}$/',
            'g-recaptcha-response' => 'required|captcha'
        ], $messages);

        $request->pdf->storeAs('public/muses', str_replace('-', '', $request->input('date')) . '.pdf');

        return $this->museIndex('Muse uploaded! Check the homepage "Latest Muse" link to ensure it is correct.');
    }

    public function museIndex($success = null)
    {
        return view('admin.muse', ['success' => $success]);
    }
}
