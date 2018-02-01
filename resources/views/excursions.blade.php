@extends('layouts.app')

@section('title')
    Excursions
@endsection

@section('heading')
    These single-day trips off the YMCA of the Ozarks campus are a blast every year!
@endsection

@section('content')
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
@endsection