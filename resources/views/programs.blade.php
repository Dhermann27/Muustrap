@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <h2>Programs</h2>
        </div>
        <div>
            @foreach($programs as $program)
                <ul class="list-group">
                    <li class="list-group-item">
                        <h3>{{ $program->name }}</h3>
                        {!! $program->blurb !!}
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
@endsection