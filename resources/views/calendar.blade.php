@extends('layouts.app')

@section('css')
    <link rel='stylesheet' href='/css/fullcalendar.min.css'/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Personalized Calendar</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($campers as $camper)
                        <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                            <a href="#{{ $camper->id }}" aria-controls="{{ $camper->id }}" role="tab"
                               data-toggle="tab">{{ $camper->firstname }} {{ $camper->lastname }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($campers as $camper)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                             id="{{ $camper->id }}">
                            <div id="calendar-{{ $camper->id }}"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src='/js/moment.min.js'></script>
    <script src='/js/fullcalendar.min.js'></script>
    <script src='/js/gcal.min.js'></script>
    <script type="text/javascript">
        $(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                e.preventDefault();
                $('#calendar-' + e.target.href.substr(-4)).fullCalendar('render');
            })
        });

        @foreach($campers as $camper)
        $('#calendar-{{ $camper->id }}').fullCalendar({
            header: {
                left: '', center: '', right: ''
            },
            googleCalendarApiKey: '{{ env('GOOGLE_API_KEY') }}',
            theme: true,
            showNonCurrentDates: false,
            allDaySlot: false,
            minTime: '06:00:00',
            defaultView: 'agendaWeek',
            defaultDate: '{{  $year->start_date }}',
            @if(!empty($camper->program->calendar))
            events: {
                googleCalendarId: '{{ $camper->program->calendar }}',
                color: 'indianred'
            },
            @endif
            eventSources: [
                {
                    events: [
                            @foreach($camper->yearattending->workshops()->where('is_enrolled', '1')->get() as $signup)
                            @foreach($signup->workshop->days($year) as $day)
                        {
                            'title': '{{  $signup->workshop->name }}',
                            'start': ' {{ $day[0] }}',
                            'end': ' {{  $day[1] }}'
                        },
                        @endforeach
                        @endforeach
                    ]
                }
            ]

        })
        ;
        @endforeach
    </script>
@endsection