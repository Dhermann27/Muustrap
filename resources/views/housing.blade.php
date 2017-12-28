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
                {!! $building->blurb !!}
                <p>&nbsp;</p>
                @if(isset($building->image))
                    <div id="carousel-{{ $building->id }}" class="carousel slide" data-ride="carousel"
                         data-interval="3500">
                        <ol class="carousel-indicators">
                            @foreach($building->image_array as $image)
                                <li data-target="#carousel-{{ $building->id }}"
                                    data-slide-to="{{ $loop->index }}" {{ $loop->first ? ' class="active"' : '' }}></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach($building->image_array as $image)
                                <div class="carousel-item{{ $loop->first ? ' active' : '' }}">
                                    <img class="d-block w-100" src="/images/buildings/{{ $image }}"
                                         alt="Image of {{ $building->name }} room">
                                </div>
                            @endforeach
                        </div>
                        @if(count($building->image_array) > 1)
                            <a class="carousel-control-prev" href="#carousel-{{ $building->id }}" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-{{ $building->id }}" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        @endif
                    </div>
                    <p>&nbsp;</p>
                @endif
            </li>
        </ul>
    @endforeach
@endsection