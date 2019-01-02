@extends('layouts.appstrap')

@section('title')
    Housing Options
@endsection

@section('heading')
    Check out all the available room types we have in the wonderful YMCA of the Ozarks facilities!
@endsection

@section('image')
    /images/housing.png
@endsection

@section('content')
    <div class="container px-3 py-5 px-lg-4 py-lg-6 bg-grey mb-5">
        @foreach($buildings as $building)
            @component('snippet.blog', ['title' => $building->name])

                <div class="mt-2">{!! $building->blurb !!}</div>

                @if(isset($building->image))
                    <div class="mt-4 owl-dots-center owl-nav-over owl-nav-over-lg owl-nav-over-hover"
                         data-toggle="owl-carousel"
                         data-owl-carousel-settings='{"items":1, "center":true, "autoplay":true, "loop":true, "dots":true, "nav":true, "animateOut":"fadeOutDown"}'>
                        @foreach($building->image_array as $image)
                            <div class="item">
                                <img src="/images/buildings/{{ $image }}" alt="Image of {{ $building->name }} room"
                                     class="img-fluid"/>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endcomponent
        @endforeach
    </div>
@endsection