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
                <li class="page-item{!! $loop->first ? ' active' : '' !!}">
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
    <div align="right">Total Number of Families: {{ count($letters) }}</div>
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
                    <tr>
                        <td colspan="3">
                            <table class="table table-sm w-auto">
                                @foreach($family->allcampers()->orderBy('birthdate')->get() as $camper)
                                    <tr>
                                        <td width="33%">{{ $camper->lastname }}, {{ $camper->firstname }}
                                            @if(isset($camper->email))
                                                <a href="mailto:{{ $camper->email }}"
                                                   class="fa fa-envelope"></a>
                                            @endif
                                        </td>
                                        <td width="33%">{{ $camper->formatted_phone }}</td>
                                        <td width="34%">{{ $camper->birthday }}</td>
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
            $(".page-link:not('#prev,#next')").on('click', function () {
                $("li.active").removeClass("active");
                $(this).parent().addClass("active");
                $(".letterdiv:visible").fadeOut(250);
                $("#" + $(this).text()).fadeIn();
            });

            $("#prev").on('click', function () {
                var active = $('li.active');
                if (active.prev().find("a").attr("id") !== "prev") {
                    active.removeClass("active").prev().addClass("active");
                    $(".letterdiv:visible").fadeOut(250).prev().fadeIn(250);
                }
            });

            $("#next").on('click', function () {
                var active = $('li.active');
                if (active.next().find("a").attr("id") !== "next") {
                    active.removeClass("active").next().addClass("active");
                    $(".letterdiv:visible").fadeOut(250).next().fadeIn(250);
                }
            })
        })
        ;
    </script>
@endsection