@extends('layouts.appstrap')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.min.css"/>
@endsection

@section('title')
    Volunteer Opportunities
@endsection

@section('heading')
    Please consider volunteering some of your time for some of the various areas where we need help.
@endsection

@section('content')
    <div class="container">
        <form id="volunteerform" class="form-horizontal" role="form" method="POST"
              action="{{ url('/volunteer' . (isset($readonly) && $readonly === false ? '/f/' . $campers->first()->familyid : '')) }}">
            @include('snippet.flash')

            @component('snippet.navtabs', ['tabs' => $campers, 'id'=> 'id', 'option' => 'fullname'])

                @foreach($campers as $camper)
                    <div class="tab-content" id="{{ $camper->id }}">
                        <input type="hidden" id="{{ $camper->id }}-volunteer"
                               name="{{ $camper->id }}-volunteer" class="volunteer-choices"/>
                        <div class="list-group col-md-4 col-sm-6">
                            <h5>Available Positions</h5>
                            @foreach($positions->sortBy('name') as $position)
                                <button type="button" data-content="{{ $position->id }}"
                                        id="{{ $camper->id }}-{{ $position->id }}"
                                        class="list-group-item list-group-item-action">
                                    {{ $position->name }}
                                </button>
                            @endforeach
                        </div>
                        @if(count($campers) > 1)
                            @include('snippet.formgroup', ['type' => 'next', 'label' => '', 'attribs' => ['name' => 'Next Camper']])
                        @endif
                    </div>
                @endforeach
            @endcomponent
            @if(!isset($readonly) || $readonly === false)
                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
            @endif
        </form>
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
            $("button.list-group-item").on("click", function (e) {
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
        });
    </script>
@endsection