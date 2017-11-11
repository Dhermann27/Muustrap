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
            </li>
        </ul>
    @endforeach
@endsection