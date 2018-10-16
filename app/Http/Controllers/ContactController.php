<?php

namespace App\Http\Controllers;

use App\Mail\ArtFair;
use App\Mail\ContactUs;
use App\Mail\Proposal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function contactStore(Request $request)
    {
        $messages = [
            'message.not_regex' => 'This contact form does not accept the Bible as the Word of God.',
            'g-recaptcha-response.required' => 'Please check the CAPTCHA box and follow any additional instructions.',
        ];

        if (Auth::check()) {
            $camper = Auth::user()->camper;
            $request["name"] = $camper->firstname . " " . $camper->lastname;
            $request["email"]  = $camper->email;
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'mailbox' => 'required|exists:contactboxes,id',
            'message' => 'required|min:5|not_regex:/scripture/|not_regex:/gospel/|not_regex:/infallible/',
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);

        $emails = explode(',', \App\Contactbox::findOrFail($request->mailbox)->emails);

        Mail::to($emails)->send(new ContactUs($request));

        $request->session()->flash('success', 'Message sent! Please expect a response in 1-3 business days.');

        return redirect()->action('ContactController@contactIndex');
    }

    public function contactIndex()
    {
        $camper = null;
        if (Auth::check()) {
            $camper = Auth::user()->camper;
        }
        return view('contactus', ['mailboxes' => \App\Contactbox::orderBy('id')->get(), 'camper' => $camper]);
    }

    public function proposalStore(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'Please check the CAPTCHA box and follow any additional instructions.',
        ];

        $this->validate($request, [
            'type' => 'required|in:Workshop,Vespers,Special Event',
            'name' => 'required|min:5',
            'message' => 'required|min:5|max:500',
            'qualifications' => 'required|min:5',
            'atmuusa' => 'required',
            'atelse' => 'required',
            'ages' => 'required|in:Adults,All Ages,Young Adults,Senior High,Junior High',
            'days' => 'required',
            'timeslot' => 'required|exists:timeslots,name',
            'room' => 'required',
            'equip' => 'required',
            'fee' => 'required',
            'capacity' => 'required',
            'waive' => 'required|in:No,Yes',
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);

        $camper = Auth::user()->camper;
        Mail::to(env('PROPOSAL_EMAIL'))->send(new Proposal($request, $camper));

        $request->session()->flash('success', 'Message sent! You will be contact by a member of the Adult Programming Committee.');

        return redirect()->action('ContactController@proposalIndex', ['camper' => $camper]);
    }

    public function proposalIndex($camper = null)
    {
        if ($camper == null) {
            $camper = Auth::user()->camper;
        }
        return view('proposal', ['camper' => $camper, 'timeslots' => \App\Timeslot::all()]);
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

        Mail::to(env('ARTFAIR_EMAIL'))->send(new ArtFair($request, Auth::user()->thiscamper));

        $request->session()->flash('success', 'Message sent! Replies will be sent to all applicants by May 1st.');

        return redirect()->action('ContactController@artfairIndex');
    }

    public function artfairIndex()
    {
        $camper = null;
        if (Auth::check()) {
            $camper = Auth::user()->thiscamper;
        }
        return view('artfair', ['camper' => $camper]);
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

        $request->session()->flash('success', 'Muse uploaded! Check the homepage "Latest Muse" link to ensure it is correct.');

        return redirect()->action('ContactController@museIndex');
    }

    public function museIndex()
    {
        return view('admin.muse');
    }
}
