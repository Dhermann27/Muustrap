@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <h2>Housing Options</h2>
        </div>
        <div>
            @foreach($buildings as $building)
                <ul class="list-group">
                    <li class="list-group-item">
                        <h3>{{ $building->name }}</h3>
                        {!! $building->blurb !!}
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
@endsection