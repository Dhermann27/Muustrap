@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Workshop Preferences</div>
            <div class="panel-body">
                <form id="workshops" class="form-horizontal" role="form" method="POST"
                      action="{{ url('/workshopchoice' .
                      (isset($readonly) && $readonly === false ? '/f/' . $campers->first()->familyid : '')) }}">
                    {{ csrf_field() }}

                    @if(!empty($success))
                        <div class="alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
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
                                <input type="hidden" id="{{ $camper->id }}-workshops"
                                       name="{{ $camper->id }}-workshops" class="workshop-choices"/>
                                @if(in_array($camper->programid, ['1008', '1009', '1006']) )
                                    @foreach($timeslots as $timeslot)
                                        <div class="list-group col-md-4 col-sm-6">
                                            <h5>{{ $timeslot->name }}
                                                @if($timeslot->id != 1005)
                                                    ({{ $timeslot->start_time->format('g:i A') }}
                                                    - {{ $timeslot->end_time->format('g:i A') }})
                                                @endif
                                            </h5>
                                            @include('workshopchoicelist', ['timeslot' => $timeslot, 'camperid' => $camper->id])
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
                                            @include('workshopchoicelist', ['timeslot' => $timeslot, 'camperid' => $camper->id])
                                        </div>
                                    @endforeach
                                @endif
                                @if(count($campers) > 1)
                                    <div class="col-md-2 col-md-offset-8">
                                        <button type="button" class="btn btn-default next">
                                            Next Camper
                                        </button>
                                    </div>
                                @endif
                                @if(!isset($readonly) || $readonly === false)
                                    <div class="col-md-2 col-md-offset-8">
                                        <button type="submit" class="btn btn-primary">
                                            Save Preferences
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
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
            $(".workshoplist button").on("click", function (e) {
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
            $('.next').click(function () {
                $('.nav-tabs > .active').next('li').find('a').trigger('click');
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            });
        });
    </script>
@endsection