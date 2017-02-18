@extends('layouts.app')

@section('css')
    <style>
        svg {
            background-image: url('/images/rooms.jpg');
            overflow: visible;
        }

        rect.available {
            opacity: 0;
        }

        rect.highlight {
            opacity: 1;
            fill: #67b021;
            cursor: pointer;
        }

        rect.unavailable {
            opacity: 1;
            fill: #2f2f2f;
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
            <svg id="rooms" height="828" width="878"> 
                @foreach($rooms as $room) 
                <rect id="{{ $room->id }}"
                      class="{{ (isset($camper->yearattending->roomid) && $room->id == $camper->yearattending->roomid) || (isset($room->locked) && strpos($room->locked, $camper->lastname) !== false) ? 'active' : '' }}
                      {{ (isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '1') || (isset($room->locked) && strpos($room->locked, $camper->lastname) === false && $room->capacity < 10) ?  'unavailable' : 'available' }}"
                      width="{{ $room->pixelsize }}" height="{{ $room->pixelsize }}" x="{{  $room->xcoord }}"
                      y="{{ $room->ycoord }}" rx="5" ry="5" data-content="{!!  $room->room_name !!}{!! isset($room->occupants) ?
                                    '<br/>' . $room->occupants :
                                    (isset($room->locked) && $room->capacity < 10 ?
                                        '<br/><i>Locked by</i>:<br />' . $room->locked
                                    : '') !!}{!! (isset($camper->yearattending->roomid) && $room->id == $camper->yearattending->roomid) || (isset($room->locked) && strpos($room->locked, $camper->lastname) !== false) ?
                                    '<br/><strong>Your Current Selection</strong>' .
                                        ($room->capacity < 10 ?
                                            '<br />Please note that changing from this room will make it available to other campers.<br /><i>This cannot be undone!</i>' :
                                            '')
                                    : '' !!}"></rect> 
                @endforeach
            </svg>
        </div>
        @if(isset($camper->yearattending) && $camper->yearattending->is_setbyadmin == '1')
            <div class="col-md-2 col-md-offset-8">
                <button type="submit" class="btn btn-disabled" disabled>
                    Room Locked By Registrar
                </button>
            </div>
        @elseif(!$is_priority || $camper->prereg)
            <form id="roomselection" method="POST" action="{{ url('/roomselection') }}">
                {{ csrf_field() }}
                <input type="hidden" id="roomid" name="roomid"/>
                <div class="col-md-2 col-md-offset-8">
                    <button type="submit" class="btn btn-primary">
                        Lock Room
                    </button>
                </div>
            </form>
        @else
            <div class="col-md-2 col-md-offset-8">
                <button type="submit" class="btn btn-disabled" disabled>
                    Room Selection Available {{ $open->format('F jS') }}
                </button>
            </div>
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
    $('rect.available').on('click', function () {
        $('rect.available').removeClass('active');
        $(this).addClass('active');
    });
    $('#roomselection').on('submit', function (e) {
        $("#roomid").val($("rect.active").first().attr("id"));
        return true;
    })
</script>
@endsection