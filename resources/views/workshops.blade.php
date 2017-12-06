@extends('layouts.app')

@section('title')
    Workshop List
@endsection

@section('heading')
    This page contains a list of the workshops we have on offer this year, grouped by timeslot.
@endsection

@section('content')
    @include('snippet.navtabs', ['tabs' => $timeslots, 'id'=> 'id', 'option' => 'name'])

    <div class="tab-content">
        @foreach($timeslots as $timeslot)
            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }} p-3"
                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $timeslot->id }}">
                <h4>{{ $timeslot->start_time->format('g:i A') }}
                    - {{ $timeslot->end_time->format('g:i A') }}</h4>
                @foreach($timeslot->workshops as $workshop)
                    <ul class="list-group">
                        <li class="list-group-item">
                            @include('snippet.filling', ['workshop' => $workshop])
                            <h3>{{ $workshop->name }}</h3>
                            <h5>Led by {{ $workshop->led_by }}</h5>
                            <p>{{ $workshop->blurb }} <i>Days: {{ $workshop->displayDays }}</i></p>
                        </li>
                    </ul>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection