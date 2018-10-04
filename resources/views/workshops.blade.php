@extends('layouts.app')

@section('title')
    Workshop List
@endsection

@section('heading')
    This page contains a list of the workshops
    @if($year->is_live)
        we have on offer this year, grouped by timeslot.
    @else
        we had on offer last year, as an example of what might be available.
    @endif
@endsection

@section('content')
    <section id="workshops">
        @component('snippet.navtabs', ['tabs' => $timeslots, 'id'=> 'id', 'option' => 'name'])
            @foreach($timeslots as $timeslot)
                <div class="tab-content" id="{{ $timeslot->id }}">

                    <h2 class="ml-3">{{ $timeslot->start_time->format('g:i A') }}
                        - {{ $timeslot->end_time->format('g:i A') }}</h2>
                    @foreach($timeslot->workshops as $workshop)

                        <div class="col-lg-11 col-lg-offset-1 mb-5">

                            <h3 class="post-title">
                                {{ $workshop->name }}
                            </h3>

                            <ul class="meta">
                                <li class="categories">Led by {{ $workshop->led_by }}</li>
                                <li class="comments">Days: {{ $workshop->displayDays }}</li>
                                @if($workshop->fee > 0)
                                    <li class="likes">Fee: {{ $workshop->fee }}</a></li>
                                @endif
                            </ul>
                            @include('snippet.filling', ['workshop' => $workshop])

                            <p>{{ $workshop->blurb }}</p>

                            <hr/>

                        </div>
                    @endforeach
                </div>
            @endforeach
        @endcomponent
    </section>
@endsection