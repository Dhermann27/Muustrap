@extends('layouts.app')

@section('title')
    Programs
@endsection

@section('heading')
    Learn more about the age-specific groups into which we divide our campers, and what to expect for people of all ages.
@endsection

@section('content')
    @foreach($programs as $program)
        <ul class="list-group">
            <li class="list-group-item">
                <h3>{{ $program->name }}</h3>
                {!! $program->blurb !!}
            </li>
        </ul>
    @endforeach
@endsection