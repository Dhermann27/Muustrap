@extends('layouts.app')

@section('title')
    Online Directory
@endsection

@section('heading')
    This handy resource, in the interest of privacy, only contains entries of campers who attended the same year(s) as yourself.
@endsection

@section('content')
    <div class="alert alert-info">
        Unfortunately, we do not have historical data from Lake Geneva Summer Assembly.
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center pt-3">
            <li class="page-item">
                <a href="#" class="page-link" id="prev" aria-label="Previous">
                    <i class="fa fa-chevron-left fa-fw"></i>
                </a>
            </li>
            @foreach($letters->groupBy('first') as $letter => $families)
                <li class="page-item letters{!! $loop->first ? ' active' : '' !!}">
                    <a href="#" class="page-link">{{ $letter }}</a>
                </li>
            @endforeach
            <li class="page-item">
                <a href="#" class="page-link" id="next" aria-label="Next">
                    <i class="fa fa-chevron-right fa-fw"></i>
                </a>
            </li>
        </ul>
    </nav>
    <div class="row">
        <div class="col-md-4 m-2">
            <input id="search" class="form-control" placeholder="Search" autocomplete="off"/>
        </div>
        <div class="col-md-7 pt-3" align="right">Total Number of Families: {{ count($letters) }}</div>
    </div>
    @foreach($letters->groupBy('first') as $letter => $families)
        <div id="{{ $letter }}" class="letterdiv" {!!  !$loop->first ? ' style="display: none;"' : '' !!}>
            <table class="table table-bordered w-auto">
                <thead>
                <tr>
                    <th width="50%">Family</th>
                    <th width="25%">Location</th>
                    <th width="25%">Years Attended</th>
                </tr>
                </thead>
                @foreach($families as $family)
                    <tr class="family">
                        <td>{{ $family->name }}</td>
                        <td>{{ $family->city }}, {{ $family->statecd }}</td>
                        <td align="right">{!! $family->formatted_years !!}</td>
                    </tr>
                    <tr class="members">
                        <td colspan="3">
                            <table class="table table-sm w-auto">
                                @foreach($family->allcampers()->orderBy('birthdate')->get() as $camper)
                                    <tr>
                                        <td width="4%">
                                            @if(isset($pix[$camper->firstname . ' ' . $camper->lastname]))
                                                <a href="{{ $pix[$camper->firstname . ' ' . $camper->lastname]["link"] }}"><img
                                                            src="{{ $pix[$camper->firstname . ' ' . $camper->lastname]["url"] }}"
                                                            alt="{{ $camper->firstname }} {{ $camper->lastname }}"/></a>
                                            @endif
                                        </td>
                                        <td width="33%" class="name align-middle">{{ $camper->lastname }}
                                            , {{ $camper->firstname }}
                                            @if(isset($camper->email))
                                                <a href="mailto:{{ $camper->email }}">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td width="31%" class="align-middle"><a href="tel:+1{{ $camper->phonenbr }}">
                                                {{ $camper->formatted_phone }}
                                            </a>
                                        </td>
                                        <td width="31%" class="align-middle">{{ $camper->birthday }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
@endsection

@section('script')
    <script>
        $(function () {
            $(".letters").on('click', function () {
                if (!$(this).hasClass("disabled")) {
                    $("li.active").removeClass("active");
                    $(this).addClass("active");
                    $(".letterdiv:visible").fadeOut(250);
                    $("#" + $(this).find("a").text()).fadeIn();
                }
            });

            $("#prev").on('click', function () {
                var active = $('li.active');
                var prev = active.prevAll("li:not('.disabled')").first();
                if (prev.find("a").attr("id") !== "prev") {
                    active.removeClass("active");
                    prev.addClass("active");
                    $(".letterdiv:visible").fadeOut(250);
                    $("#" + prev.find("a").text()).fadeIn();
                }
            });

            $("#next").on('click', function () {
                var active = $('li.active');
                var next = active.nextAll(":not('.disabled')").first();
                if (next.find("a").attr("id") !== "next") {
                    active.removeClass("active");
                    next.addClass("active");
                    $(".letterdiv:visible").fadeOut(250);
                    $("#" + next.find("a").text()).fadeIn();
                }
            });

            $("#search").keyup(function () {
                $("tr.family").each(function () {
                    $(this).hide().next().hide();
                });
                $(".letters").addClass("disabled");
                $("tr.family:contains('" + $(this).val() + "')").each(function () {
                    $(this).show().next().show();
                    $(".letters:contains('" + $(this).find("td:first").text().substr(0, 1) + "')").removeClass("disabled");
                });
                $("td.name:contains('" + $(this).val() + "')").each(function () {
                    var letter = $(this).parents(".members").show().prev().show().find("td:first").text().substr(0, 1);
                    $(".letters:contains('" + letter + "')").removeClass("disabled");
                });
                if ($("li.active").hasClass("disabled")) {
                    $(".letters:not('.disabled'):first a").click();
                }
            });
        });
    </script>
@endsection