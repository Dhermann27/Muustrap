@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <h2>Workshop List</h2>
        </div>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                @foreach($timeslots as $timeslot)
                    <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                        <a href="#{{ $timeslot->id }}" aria-controls="{{ $timeslot->id }}" role="tab"
                           data-toggle="tab">{{ $timeslot->name }}</a></li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($timeslots as $timeslot)
                    <div role="tabpanel" class="tab-pane{{ $loop->first ? '  active' : '' }}" id="{{ $timeslot->id }}">
                        <h4>{{ $timeslot->start_time->format('g:i A') }}
                            - {{ $timeslot->end_time->format('g:i A') }}</h4>
                        @foreach($timeslot->workshops as $workshop)
                            <ul class="list-group">
                                <li class="list-group-item">
                                    @if($workshop->capacity == 999)
                                        <span class="alert alert-success badge">Unlimited Enrollment</span>
                                    @elseif($workshop->enrolled >= $workshop->capacity)
                                        <span class="alert alert-danger badge">Waitlist Available</span>
                                    @elseif($workshop->enrolled >= ($workshop->capacity * .75))
                                        <span class="alert alert-warning badge">Filling Fast!</span>
                                    @else
                                        <span class="alert alert-info badge">Open For Enrollment</span>
                                    @endif
                                    <h3>{{ $workshop->name }}</h3>
                                    <h5>Led by {{ $workshop->led_by }}</h5>
                                    <p>{{ $workshop->blurb }} <i>Days: {{ $workshop->displayDays }}</i></p>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection