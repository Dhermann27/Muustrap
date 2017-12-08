@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('title')
    Workshop Preferences
@endsection

@section('heading')
    Use this page to choose from the available workshops for the various timeslots of the day.
@endsection

@section('content')
    <div class="container">
        <form id="workshops" class="form-horizontal" role="form" method="POST"
              action="{{ url('/workshopchoice' . (isset($readonly) && $readonly === false ? '/f/' . $campers->first()->familyid : '')) }}">
            @include('snippet.flash')

            @include('snippet.navtabs', ['tabs' => $campers, 'id'=> 'id', 'option' => 'fullname'])

            <div class="tab-content">
                @foreach($campers as $camper)
                    <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                         aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $camper->id }}">
                        <input type="hidden" id="{{ $camper->id }}-workshops"
                               name="{{ $camper->id }}-workshops" class="workshop-choices"/>
                        <div class="row">
                            @if(in_array($camper->programid, ['1008', '1009', '1006']) )
                                @foreach($timeslots as $timeslot)
                                    <div class="list-group col-md-4 col-sm-6 pb-5">
                                        <h5>{{ $timeslot->name }}
                                            @if($timeslot->id != 1005)
                                                ({{ $timeslot->start_time->format('g:i A') }}
                                                - {{ $timeslot->end_time->format('g:i A') }})
                                            @endif
                                        </h5>
                                        @include('snippet.workshops', ['timeslot' => $timeslot, 'camperid' => $camper->id])
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-8 col-sm-6">
                                    <p>&nbsp;</p>
                                    Camper has been automatically enrolled in
                                    <strong>{{ $camper->programname }}</strong> programming.
                                </div>
                                @foreach($timeslots->where('id', '1005') as $timeslot)
                                    <div class="list-group col-md-4 col-sm-6">
                                        <h5>{{ $timeslot->name }}</h5>
                                        @include('snippet.workshops', ['timeslot' => $timeslot, 'camperid' => $camper->id])
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if(count($campers) > 1)
                            @include('snippet.formgroup', ['type' => 'next', 'label' => '', 'attribs' => ['name' => 'Next Camper']])
                        @endif
                    </div>
                @endforeach
            </div>
            @if(!isset($readonly) || $readonly === false)
                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Preferences']])
            @endif
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            @foreach($campers as $camper)
            @foreach($camper->yearattending->workshops as $choice)
            $("#{{ $camper->id }}-{{ $choice->workshopid }}").addClass("active");
            @endforeach
            @endforeach
            $("form#workshops button.list-group-item").on("click", function (e) {
                e.preventDefault();
                $(this).toggleClass("active");
            });
            $("#workshops").on("submit", function (e) {
                $("div.tab-pane").each(function () {
                    var ids = new Array();
                    $(this).find("button.active").each(function () {
                        ids.push($(this).attr("data-content"));
                    });
                    $("#" + $(this).attr("id") + "-workshops").val(ids.join(","));
                });
                return true;
            });
            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });
        });
    </script>
@endsection