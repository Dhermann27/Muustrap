@extends('layouts.app')

@section('css')
    <style>
        svg {
            background-image: url('/images/rooms.png');
            overflow: visible;
        }

        .svgText {
            pointer-events: none;
        }

        rect.available {
            opacity: 1;
            fill: #fff;
        }

        rect.highlight {
            opacity: 1;
            fill: #67b021;
            cursor: pointer;
        }

        rect.unavailable {
            opacity: 1;
            fill: darkgray;
            cursor: not-allowed;
        }

        rect.active {
            opacity: 1;
            fill: #daa520;
        }

        .tooltip {
            background: sandybrown;
            border: solid gray;
            position: absolute;
            max-width: 20em;
            font-size: 1.1em;
            pointer-events: none; /*let mouse events pass through*/
            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: #0f0f0f;
            padding: 3px;
        }
    </style>
@endsection

@section('title')
    Room Selection Tool
@endsection

@section('heading')
    This easy-to-use tool will let you choose from the remaining available rooms this year, and see who your neighbors might be!
@endsection

@section('content')
    <div class="container">
        <form id="roomselection" method="POST" action="{{ url('/roomselection') }}">
            @include('snippet.flash')

            <svg id="rooms" height="731" width="1152">
                <text x="30" y="40" font-family="Roboto" font-size="36px" fill="white">Trout Lodge</text>
                <text x="15" y="80" font-family="Roboto" font-size="36px" fill="white">Guest Rooms</text>
                <text x="320" y="-215" transform="rotate(90)" font-family="Roboto" font-size="36px" fill="white">Loft
                    Suites
                </text>
                <text x="402" y="450" font-family="Roboto" font-size="36px" fill="white">Lakeview Cabins</text>
                <text x="255" y="200" font-family="Roboto" font-size="36px" fill="white">Forestview Cabins</text>
                <text x="540" y="267" font-family="Roboto" font-size="36px" fill="white">Tent Camping</text>
                <text x="740" y="85" font-family="Roboto" font-size="36px" fill="white">Camp Lakewood Cabins</text>
                <text x="910" y="460" font-family="Roboto" font-size="36px" fill="white">Commuter</text>
                @foreach($rooms as $room)
                    <g>
                        <rect id="{{ $room->id }}"
                              class="{{ (isset($camper->yearattending->roomid) && $room->id == $camper->yearattending->roomid) || (isset($room->locked) && strpos($room->locked, $camper->lastname) !== false) ? 'active' : '' }}
                              {{ (isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '1') || ((isset($room->occupants) || isset($room->locked)) && strpos($room->occupants . $room->locked, $camper->lastname) === false && $room->capacity < 10) ?  'unavailable' : 'available' }}"
                              width="{{ $room->pixelsize }}" height="{{ $room->pixelsize }}" x="{{  $room->xcoord }}"
                              y="{{ $room->ycoord }}" data-content="{!!  $room->room_name !!}{!! isset($room->occupants) ?
                            '<br/>' . $room->occupants :
                            (isset($room->locked) && $room->capacity < 10 ?
                                '<br/><i>Locked by</i>:<br />' . $room->locked
                            : '') !!}{!! (isset($camper->yearattending->roomid) && $room->id == $camper->yearattending->roomid) || (isset($room->locked) && strpos($room->locked, $camper->lastname) !== false) ?
                            '<br/><strong>Your Current Selection</strong>' .
                                ($room->capacity < 10 ?
                                    '<br />Please note that changing from this room will make it available to other campers.<br /><i>This cannot be undone!</i>' :
                                    '')
                            : '' !!}"></rect>

                        <text class="svgText" x="{{ $room->xcoord+3 }}" y="{{ $room->ycoord+$room->pixelsize/1.62 }}"
                              font-size="12px">{{ $room->pixelsize < 50 ? $room->room_number : ''}}</text>
                    </g>
                @endforeach
            </svg>
            @if(isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '1')
                <div class="text-lg-right">
                    <input type="submit" class="btn btn-lg btn-primary disabled py-3 px-4"
                           value="Room Locked By Registrar"/>
                </div>
            @elseif(!empty($camper->lastname) && $year->is_room_select)
                <input type="hidden" id="roomid" name="roomid"/>
                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Lock Room']])
            @endif
        </form>
    </div>
    <p>&nbsp;</p>
    <div class="tooltip"></div>
@endsection

@section('script')
    <script>
        $('rect').on('mouseover', function (event) {
            $(this).addClass('highlight');
            $('div.tooltip').html($(this).attr('data-content')).css({
                'opacity': '1',
                'top': (window.pageYOffset + event.clientY + 30) + 'px',
                'left': (window.pageXOffset + event.clientX) + 'px'
            });
        }).on('mouseout', function () {
            $(this).removeClass('highlight');
            return $('div.tooltip').css('opacity', '0');
        });
        @if(isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '0')
        $('rect.available').on('click', function () {
            $('rect.available').removeClass('active');
            $(this).addClass('active');
        });
        $('#roomselection').on('submit', function (e) {
            if (!confirm("You are moving {{ $count }} campers to a new room. This cannot be undone. Is this correct?")) {
                return false;
            }
            $("#roomid").val($("rect.active").first().attr("id"));
            return true;
        });
        @endif
    </script>
@endsection