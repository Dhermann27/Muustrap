@extends('layouts.app')

@section('title')
    Housing Options
@endsection

@section('heading')
    Check out all the available room types we have in the wonderful YMCA of the Ozarks facilities!
@endsection

@section('content')
    @component('snippet.blog')
        @foreach($buildings as $building)
            <div class="post-content">

                <h2 class="post-title">{{ $building->name }}</h2>

                <p>{!! $building->blurb !!}</p>

                @if(isset($building->image))
                    <div id="owl-work"
                         class="owl-carousel owl-inner-pagination owl-inner-nav post-media">
                        @foreach($building->image_array as $image)
                            <div class="item">
                                <figure>
                                    <img src="/images/buildings/{{ $image }}"
                                         alt="Image of {{ $building->name }} room">
                                </figure>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    @endcomponent
@endsection