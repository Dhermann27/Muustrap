@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <h2>Workshop Attendees</h2>
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
                    <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                         id="{{ $timeslot->id }}">
                        <h4>{{ $timeslot->start_time->format('g:i A') }}
                            - {{ $timeslot->end_time->format('g:i A') }}</h4>
                        @foreach($timeslot->workshops as $workshop)
                            <h4>{{ $workshop->name }} ({{ count($workshop->choices) }} / {{ $workshop->capacity }})</h4>
                            <h5>Led by {{ $workshop->led_by }}</h5>
                            <table class="table table-responsive table-condensed">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sign Up Date</th>
                                    <th>Controls</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($workshop->choices()->orderBy('created_at')->get() as $choice)
                                        <tr>
                                            <td>{{ $choice->yearattending->camper->lastname }}
                                                , {{ $choice->yearattending->camper->firstname }}</td>
                                            <td>{{ $choice->created_at }}</td>
                                            <td>
                                                @include('admin.controls', ['id' => 'c/' . $choice->yearattending->camper->id])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection