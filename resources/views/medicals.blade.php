@extends('layouts.app')
@inject('home', 'App\Http\Controllers\HomeController')

@section('css')
    <link rel="stylesheet" href="/css/print.css" type="text/css" media="print"/>
@endsection

@section('title')
    MUUSA Program/Medical Letters
@endsection

@section('content')
    @foreach($campers as $camper)
        <h2>{{ $camper->firstname . ' ' . $camper->lastname }}</h2>

        @include('snippet.medical', ['camper' => $camper, 'first' => $loop->first])


        <div align="right">
            <h4>Signature of parent/guardian:
                ____________________________________________________</h4>
            <h4>Signature of camper:
                ____________________________________________________</h4>
        </div>

        <footer>&nbsp;</footer>
    @endforeach
@endsection

