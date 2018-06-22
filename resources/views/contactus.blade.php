@extends('layouts.app')

@section('title')
    Contact Us
@endsection

@section('heading')
    Send an email to the right person to answer your questions or concerns.
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/contact') }}">
            @include('snippet.flash')

            @if(Auth::check() && !empty($camper))
                @include('snippet.formgroup', ['type' => 'info', 'label' => 'Your Name', 'attribs' => ['name' => 'name'],
                    'default' => $camper->firstname . ' ' . $camper->lastname])

                @include('snippet.formgroup', ['type' => 'info', 'label' => 'Email Address', 'attribs' => ['name' => 'email'],
                    'default' => Auth::user()->email])
            @else
                @include('snippet.formgroup', ['label' => 'Your Name', 'attribs' => ['name' => 'name']])

                @include('snippet.formgroup', ['label' => 'Email Address', 'attribs' => ['name' => 'email']])
            @endif

            @include('snippet.formgroup', ['type' => 'select', 'label' => 'Recipient Mailbox',
                'attribs' => ['name' => 'mailbox'], 'default' => 'Choose a recipient mailbox', 'list' => $mailboxes,
                'option' => 'name'])

            @include('snippet.formgroup', ['type' => 'text', 'label' => 'Message', 'attribs' => ['name' => 'message']])

            @include('snippet.formgroup', ['type' => 'captcha', 'label' => 'CAPTCHA Test',
                'attribs' => ['name' => 'g-recaptcha-response']])

            @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Send Message']])
        </form>
    </div>
@endsection

@section('script')
    {!! NoCaptcha::renderJs() !!}
@endsection