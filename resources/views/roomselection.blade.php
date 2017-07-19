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
            fill: #a94442;
            cursor: not-allowed;
        }

        rect.active {
            opacity: 1;
            fill: #daa520;
        }

        .tooltip {
            background: lightblue;
            border: solid gray;
            position: absolute;
            max-width: 20em;
            font-size: 1.1em;
            pointer-events: none; /*let mouse events pass through*/
            opacity: 0;
            padding: 5px;
            transition: opacity 0.3s;
        }
    </style>
     @endsection

@section('content') 
<div class="container"> 
    <div class="row">
        <h2>Room Selection Tool</h2>
    </div>
    <div class="row">
        <div class="col-lg-10"> 
            @if(!empty($success))
                <div class="alert alert-success">
                    {!! $success !!}
                </div>
            @endif
            @if(count($errors))
                <div class="alert alert-danger">
                    {{ $errors->first('roomid') }}
                </div>
            @endif

            @if(isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '1')
                <div class="alert alert-warning">
                    Your room has been locked by the Registrar. Please use the Contact Us form above to request any
                    changes at this point.
                </div>
            @endif

            <svg id="rooms" height="731" width="1152"> 
                <text x="30" y="40" font-family="Roboto" font-size="36px" fill="white">Trout Lodge</text>
                <text x="15" y="80" font-family="Roboto" font-size="36px" fill="white">Guest Rooms</text>
                <text x="320" y="-215" transform="rotate(90)" font-family="Roboto" font-size="36px" fill="white">Loft Suites</text>
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
        </div>
        @if(isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '1')
            <div class="col-md-2 col-md-offset-8">
                <button type="submit" class="btn btn-disabled" disabled>
                    Room Locked By Registrar
                </button>
            </div>
        @elseif(!empty($camper->lastname))
            <form id="roomselection" method="POST" action="{{ url('/roomselection') }}">
                {{ csrf_field() }}
                <input type="hidden" id="roomid" name="roomid"/>
                <div class="col-md-2 col-md-offset-8">
                    <button type="submit" class="btn btn-primary">
                        Lock Room
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
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
            $("#roomid").val($("rect.active").first().attr("id"));
            return true;
        });
    @endif
</script>
@endsection