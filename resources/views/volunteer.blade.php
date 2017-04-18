@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Volunteer Opportunities</div>
            <div class="panel-body">
                <form id="volunteerform" class="form-horizontal" role="form" method="POST"
                      action="{{ url('/volunteer' .
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
                                <input type="hidden" id="{{ $camper->id }}-volunteer"
                                       name="{{ $camper->id }}-volunteer" class="volunteer-choices"/>
                                <div class="list-group col-md-4 col-sm-6">
                                    <h5>Available Positions</h5>
                                    <div class="workshoplist">
                                        @foreach($positions as $position)
                                            <button type="button" data-content="{{ $position->id }}"
                                                    id="{{ $camper->id }}-{{ $position->id }}"
                                                    class="list-group-item">
                                                {{ $position->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                @if(count($campers) > 1)
                                    <div class="form-group">
                                        <div class="col-md-2 col-md-offset-8">
                                            <button type="button" class="btn btn-default next">
                                                Next Camper
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                @if(!isset($readonly) || $readonly === false)
                                    <div class="form-group">
                                        <div class="col-md-2 col-md-offset-8">
                                            <button type="submit" class="btn btn-primary">
                                                Save Preferences
                                            </button>
                                        </div>
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
            @foreach($camper->yearattending->volunteers as $choice)
            $("#{{ $camper->id }}-{{ $choice->volunteerpositionid }}").addClass("active");
            @endforeach
            @endforeach
            $(".workshoplist button").on("click", function (e) {
                e.preventDefault();
                $(this).toggleClass("active");
            });
            $("#volunteerform").on("submit", function (e) {
                $("div.tab-pane").each(function () {
                    var ids = new Array();
                    $(this).find("button.active").each(function () {
                        ids.push($(this).attr("data-content"));
                    });
                    $("#" + $(this).attr("id") + "-volunteer").val(ids.join(","));
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