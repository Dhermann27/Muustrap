@extends('layouts.app')

@section('title')
    Contact Us
@endsection

@section('heading')
    Send an email to the right person to answer your questions or concerns.
@endsection

@section('content')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/contact') }}">
        @include('snippet.flash')

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Your Name</label>

            <div class="col-md-6">
                @if(Auth::check() && !empty($camper))
                    <strong>{{ $camper->firstname }} {{ $camper->lastname }}</strong>
                    <input type="hidden" name="name"
                           value="{{ $camper->firstname }} {{ $camper->lastname }}"/>
                @else
                    <input id="name" class="form-control" name="name" value="{{ old('name') }}"
                           required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                @if(Auth::check())
                    <strong>{{ Auth::user()->email }}</strong>
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}"/>
                @else
                    <input id="email" type="email" class="form-control" name="email"
                           value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('mailbox') ? ' has-error' : '' }}">
            <label for="mailbox" class="col-md-4 control-label">Subject</label>

            <div class="col-md-6">
                <select id="mailbox" name="mailbox" class="form-control">
                    @foreach($mailboxes as $mailbox)
                        <option value="{{ $mailbox->id }}"{{ (old('id') == $mailbox->id) ? " selected" : "" }}>
                            {{ $mailbox->name }}
                        </option>
                    @endforeach
                </select>

                @if ($errors->has('mailbox'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('mailbox') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
            <label for="message" class="col-md-4 control-label">Message</label>

            <div class="col-md-6">
                                    <textarea id="message" class="form-control" name="message"
                                              required>{{ old('message') }}</textarea>

                @if ($errors->has('message'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
            <div class="col-md-6 col-md-offset-4">
                {!! app('captcha')->display() !!}

                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </form>
@endsection