@extends('layouts.appstrap')

@section('title')
    Programs
@endsection

@section('heading')
    Learn more about the age-specific groups into which we divide our campers, and what to expect for people of all ages.
@endsection

@section('content')
    @component('snippet.blog')
        @foreach($programs as $program)
            <div class="post-content">

                <h3 class="post-title">{{ $program->name }}</h3>

                <p>{!! $program->blurb !!}</p>
            </div>
        @endforeach
    @endcomponent
@endsection