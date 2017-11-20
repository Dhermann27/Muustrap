@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('css')
    <link rel='stylesheet' href='/css/fullcalendar.min.css'/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('title')
    Personalized Calendar
@endsection

@section('heading')
    See the up-to-date information on everything happening for you and your family during the week of MUUSA!
@endsection

@section('content')
    @include('snippet.navtabs', ['tabs' => $campers, 'id'=> 'id', 'option' => 'fullname'])

    <div class="tab-content">
        @foreach($campers as $camper)
            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $camper->id }}">
                <div id="calendar-{{ $camper->id }}"></div>
            </div>
        @endforeach
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
                left: '', center: $(window).width() < 768 ? 'prev,today,next' : '', right: ''
            },
            googleCalendarApiKey: '{{ env('GOOGLE_API_KEY') }}',
            theme: true,
            showNonCurrentDates: false,
            allDaySlot: false,
            minTime: '06:00:00',
            defaultView: $(window).width() < 768 ? 'agendaDay' : 'agendaWeek',
            defaultDate: $(window).width() < 768 ? '{{ $home->year()->next_day }}' : '{{  $home->year()->start_date }}',
            @if(!empty($camper->program->calendar))
            events: {
                googleCalendarId: '{{ $camper->each_calendar }}',
                backgroundColor: '#b3dc6c',
                borderColor: '#93c00b',
                textColor: '#1d1d1d'
            },
            @endif
            eventSources: [
                {
                    events: [
                            @foreach($camper->yearattending->workshops()->where('is_enrolled', '1')->get() as $signup)
                            @foreach($signup->workshop->days($home->year()->year) as $day)
                        {
                            'title': '{{  $signup->workshop->name }}',
                            'start': ' {{ $day[0] }}',
                            'end': ' {{  $day[1] }}'
                        },
                        @endforeach
                        @endforeach
                    ],
                    backgroundColor: '#337ab7',
                    borderColor: '#373ad7',
                    textColor: '#1d1d1d'
                }
            ]

        })
        ;
        @endforeach
    </script>
@endsection