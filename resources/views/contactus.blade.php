@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact Us</div>
                    <div class="panel-body">
                        @if (!empty($success))
                            <div class="alert alert-success">
                                {{ $success }}
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/contact') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Your Name</label>

                                <div class="col-md-6">
                                    <input id="name" class="form-control" name="name" value="{{ old('name') }}"
                                           required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mailbox') ? ' has-error' : '' }}">
                                <label for="id" class="col-md-4 control-label">Subject</label>

                                <div class="col-md-6">
                                    <select id="mailbox " name="mailbox" class="form-control">
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
                                <label for="password" class="col-md-4 control-label">Message</label>

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

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {!! app('captcha')->display('Send') !!}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection