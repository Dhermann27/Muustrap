@extends('layouts.app')

@section('title')
    MUUSA Workshop Proposal
@endsection

@section('heading')
    Send us your ideas for next year's favorite camper-led activity!
@endsection

@section('content')
    <div class="container">
        <form id="proposal" class="form-horizontal" role="form" method="POST"
              action="{{ url('/proposal') }}">

            @include('snippet.flash')

            @include('snippet.formgroup', ['type' => 'info', 'label' => 'Your Name', 'attribs' => ['name' => 'yourname'],
                'default' => $camper->firstname . ' ' . $camper->lastname])

            @include('snippet.formgroup', ['type' => 'info', 'label' => 'Email Address', 'attribs' => ['name' => 'email'],
                'default' => $camper->email])

            @include('snippet.formgroup', ['type' => 'info', 'label' => 'Address Line #1', 'attribs' => ['name' => 'address1'],
                'default' => $camper->family->address1])

            @if($camper->family->address2 != '')
                @include('snippet.formgroup', ['type' => 'info', 'label' => 'Address Line #2', 'attribs' => ['name' => 'address2'],
                    'default' => $camper->family->address2])
            @endif

            @include('snippet.formgroup', ['type' => 'info', 'label' => 'City', 'attribs' => ['name' => 'city'],
                'default' => $camper->family->city])

            @include('snippet.formgroup', ['type' => 'info', 'label' => 'State', 'attribs' => ['name' => 'state'],
                'default' => $camper->family->statecode->name])

            @include('snippet.formgroup', ['type' => 'info', 'label' => 'Zip Code', 'attribs' => ['name' => 'zip'],
                'default' => $camper->family->zipcd])

            @if($camper->phonenbr != '')
                @include('snippet.formgroup', ['type' => 'info', 'label' => 'Phone Number', 'attribs' => ['name' => 'phonenbr'],
                    'default' => $camper->formatted_phone])
            @endif

            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                <label for="type" class="col-md-4 control-label">Type of Activity</label>

                <div class="col-md-6">
                    <select id="type" name="type" class="form-control">
                        <option{{ (old('type') == "Workshop") ? " selected" : "" }}>Workshop</option>
                        <option{{ (old('type') == "Vespers") ? " selected" : "" }}>Vespers</option>
                        <option{{ (old('type') == "Special Event") ? " selected" : "" }}>Special Event
                        </option>
                    </select>

                    @if ($errors->has('type'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Proprosed Title</label>

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

            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                <label for="message" class="col-md-4 control-label">Synopsis for Brochure (500 letters or
                    fewer)</label>

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

            <div class="form-group{{ $errors->has('qualifications') ? ' has-error' : '' }}">
                <label for="qualifications" class="col-md-4 control-label">Your Qualifications</label>

                <div class="col-md-6">
                                    <textarea id="qualifications" class="form-control" name="qualifications"
                                              required>{{ old('qualifications') }}</textarea>

                    @if ($errors->has('qualifications'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('qualifications') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('atmuusa') ? ' has-error' : '' }}">
                <label for="atmuusa" class="col-md-4 control-label">Have you offered this at MUUSA
                    before? If so, when?</label>

                <div class="col-md-6">
                    <input id="atmuusa" class="form-control" name="atmuusa" value="{{ old('atmuusa') }}"
                           required>

                    @if ($errors->has('atmuusa'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('atmuusa') }}</strong>
                                    </span>
                    @endif

                </div>
            </div>

            <div class="form-group{{ $errors->has('atelse') ? ' has-error' : '' }}">
                <label for="atelse" class="col-md-4 control-label">Have you offered this elsewhere
                    before? If so, where and when?</label>

                <div class="col-md-6">
                    <input id="atelse" class="form-control" name="atelse" value="{{ old('atelse') }}"
                           required>

                    @if ($errors->has('atelse'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('atelse') }}</strong>
                                    </span>
                    @endif

                </div>
            </div>

            <div class="form-group{{ $errors->has('ages') ? ' has-error' : '' }}">
                <label for="ages" class="col-md-4 control-label">For which age groups is this
                    appropriate?</label>

                <div class="col-md-6">
                    <select id="ages" name="ages" class="form-control">
                        <option{{ (old('ages') == "Adults") ? " selected" : "" }}>Adults</option>
                        <option{{ (old('ages') == "All Ages") ? " selected" : "" }}>All Ages</option>
                        <option{{ (old('ages') == "Young Adults") ? " selected" : "" }}>Young Adults
                        </option>
                        <option{{ (old('ages') == "Senior High") ? " selected" : "" }}>Senior High
                        </option>
                        <option{{ (old('ages') == "Junior High") ? " selected" : "" }}>Junior High
                        </option>
                    </select>

                    @if ($errors->has('ages'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('ages') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('days') ? ' has-error' : '' }}">
                <label for="days" class="col-md-4 control-label">On which days would you like to offer
                    this?</label>

                <div class="col-md-6">
                    <select id="days" name="days" class="form-control">
                        <option value="M-F" {{ (old('days') == "M-F") ? " selected" : "" }}>Monday
                            through
                            Friday
                        </option>
                        <option value="MWF" {{ (old('days') == "MWF") ? " selected" : "" }}>Monday,
                            Wednesday, and Friday
                        </option>
                        <option value="TuTh" {{ (old('days') == "TuTh") ? " selected" : "" }}>Tuesday
                            and
                            Thursday
                        </option>
                        <option value="Single" {{ (old('days') == "Single") ? " selected" : "" }}>Any
                            single day
                        </option>
                    </select>

                    @if ($errors->has('days'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('days') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('timeslot') ? ' has-error' : '' }}">
                <label for="timeslot" class="col-md-4 control-label">During which time slot would you
                    prefer to offer this?</label>

                <div class="col-md-6">
                    <select id="timeslot" name="timeslot" class="form-control">
                        @foreach($timeslots as $timeslot)
                            <option value="{{ $timeslot->name }}"{{ (old('timeslot') == $timeslot->name) ? " selected" : "" }}>
                                {{ $timeslot->name }}
                                @if($timeslot->id != '1005')
                                    ({{ $timeslot->start_time->format('g:i A') }}
                                    - {{ $timeslot->end_time->format('g:i A') }})
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @if ($errors->has('timeslot'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('timeslot') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('room') ? ' has-error' : '' }}">
                <label for="room" class="col-md-4 control-label">Room Requirements (table, chairs,
                    etc.)</label>

                <div class="col-md-6">
                    <input id="room" class="form-control" name="room" value="{{ old('room') }}"
                           required>

                    @if ($errors->has('room'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('room') }}</strong>
                                    </span>
                    @endif

                </div>
            </div>

            <div class="form-group{{ $errors->has('equip') ? ' has-error' : '' }}">
                <label for="equip" class="col-md-4 control-label">Equipment Requirements (flip chart,
                    projector, etc.)</label>

                <div class="col-md-6">
                    <input id="equip" class="form-control" name="equip" value="{{ old('equip') }}"
                           required>

                    @if ($errors->has('equip'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('equip') }}</strong>
                                    </span>
                    @endif

                </div>
            </div>

            <div class="form-group{{ $errors->has('fee') ? ' has-error' : '' }}">
                <label for="fee" class="col-md-4 control-label">Participant Fee</label>

                <div class="col-md-6">
                    <input id="fee" class="form-control" name="fee" value="{{ old('fee') }}"
                           required>

                    @if ($errors->has('fee'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('fee') }}</strong>
                                    </span>
                    @endif

                </div>
            </div>

            <div class="form-group{{ $errors->has('capacity') ? ' has-error' : '' }}">
                <label for="capacity" class="col-md-4 control-label">Maximum Number of
                    Participants</label>

                <div class="col-md-6">
                    <input id="capacity" class="form-control" name="capacity"
                           value="{{ old('capacity') }}"
                           required>

                    @if ($errors->has('capacity'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('capacity') }}</strong>
                                    </span>
                    @endif

                </div>
            </div>

            <div class="form-group{{ $errors->has('waive') ? ' has-error' : '' }}">
                <label for="waive" class="col-md-4 control-label">Are you willing to volunteer your time
                    and waive camp credit?</label>
                <a href="#" class="fa fa-info" data-toggle="tooltip"
                   data-placement="left" data-html="true"
                   title="Credits to be set at Fall Planning Meeting. In the past, credit for 5-day
                                    1 hr 50 min workshop has been $300; for 3-4 day 1 hr 50 min workshops, $150."></a>

                <div class="col-md-6">
                    <select id="waive" name="waive" class="form-control">
                        <option{{ (old('waive') == "No") ? " selected" : "" }}>No</option>
                        <option{{ (old('waive') == "Yes") ? " selected" : "" }}>Yes</option>
                    </select>

                    @if ($errors->has('waive'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('waive') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
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
                    <button type="submit" class="btn btn-primary">Send Proposal</button>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection