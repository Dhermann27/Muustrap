@extends('layouts.app')

@section('title')
    Housing Options
@endsection

@section('heading')
    Check out all the available room types we have in the wonderful YMCA of the Ozarks facilities!
@endsection

@section('content')
    @foreach($buildings as $building)
        <ul class="list-group">
            <li class="list-group-item">
                <h3>{{ $building->name }}</h3>
                @if(isset($building->image))
                    <div id="carousel-{{ $building->id }}" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($building->image_array as $image)
                                <li data-target="#carousel-{{ $building->id }}"
                                    data-slide-to="{{ $loop->index }}" {{ $loop->first ? ' class="active"' : '' }}></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach($building->image_array as $image)
                                <div class="carousel-item active">
                                    <img class="d-block" src="/images/buildings/{{ $image }}"
                                         alt="Image of {{ $building->name }} room">
                                </div>
                            @endforeach
                        </div>
                @endif
                {!! $building->blurb !!}
            </li>
        </ul>
    @endforeach
@endsection