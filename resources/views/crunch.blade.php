@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1>Time for MUUSA!</h1>
        <div class="row">
            @if(count($list) > 0)
                <div class="col-md-4">
                    <div>
                        <span class="fa fa-music fa-4x"></span>
                    </div>
                    <h3>Coffeehouse Schedule: {{ $day }}</h3>
                    @if(!empty($list[1]->colorId))
                        @for($i=1; $i<count($list); $i++)
                            @if(empty($list[$i]->colorId))
                                <p>Now on stage: <strong>{{ $list[$i-1]->summary }}</strong></p>
                                <p>Coming up:</p>
                                @break
                            @endif
                        @endfor
                    @else
                        <p>Evening's acts:</p>
                    @endif
                    @if(count($list) > 0)
                        <p>
                            @foreach($list as $item)
                                @if(empty($item->colorId))
                                    @if(isset($item->summary))
                                        {{ $item->summary }}
                                    @endif
                                    @if($av && isset($item->description))
                                        ({{ $item->description }})
                                    @endif
                                    <br/>
                                @endif
                            @endforeach
                        </p>
                    @endif
                </div>
            @endif
            <div class="col-md-4">
                @if(isset($camper))
                    <div>
                        <span class="fa fa-envelope-o fa-4x"></span>
                    </div>
                    <h3>Confirmation Letter</h3>
                    <a class="booty" href="{{ url('/confirm') }}">View Confirmation Letter <i
                                class="fa fa-arrow-right"></i>
                    </a>
                    <p>&nbsp;</p>
                @endif
                <div>
                    <span class="fa fa-clock-o fa-4x"></span>
                </div>
                <h3>Check-In</h3>
                <p>Sunday July 2nd, 2:00 PM</p>
                <p>&nbsp;</p>
            </div>
            <div class="col-md-4">
                <div>
                    <span class="fa fa-map-marker fa-4x"></span>
                </div>
                <h3>Directions</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3146.3009632033245!2d-90.93029498484199!3d37.946758110019154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87d99fbc697e2a85%3A0xd139b64a63794a2f!2sYMCA+Trout+Lodge!5e0!3m2!1sen!2sus!4v1497890802008"
                        width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <a href="https://www.facebook.com/{{ Auth::guest() ? 'Muusa2013/' : 'groups/Muusans/'}}" id="fb"
       class="social fa fa-facebook-official fa-3x"></a>
    <a href="https://twitter.com/muusa1" id="twtr" class="social fa fa-twitter-square fa-3x"></a>
    @if(Auth::check())
        <a href="{{ url('/directory') }}" id="od" class="social fa fa-address-book fa-3x"></a>
        <a href="{{ url('/calendar') }}" id="cal" class="social fa fa-calendar fa-3x"></a>
    @endif
@endsection

@section('script')

@endsection