@extends('layouts.appstrap')

@section('title')
    Excursions
@endsection

@section('heading')
    These single-day trips off the YMCA of the Ozarks campus are a blast every year!
@endsection

@section('content')
    <div class="container px-3 py-5 px-lg-4 py-lg-6 bg-grey mb-5">
        @foreach($timeslot->workshops as $workshop)
            @component('snippet.blog', ['title' => $workshop->name])
                @include('snippet.filling', ['workshop' => $workshop])
                <h5>Led by {{ $workshop->led_by }}</h5>
                <p>{{ $workshop->blurb }} <i>Days: {{ $workshop->displayDays }}</i></p>
            @endcomponent
        @endforeach
    </div>
@endsection