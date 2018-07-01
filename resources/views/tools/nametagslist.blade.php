@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('title')
    Nametag List
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/tools/nametags') }}">
            @include('snippet.flash')

            <table class="table">
                <thead>
                <tr>
                    <th>Famiy Name</th>
                    <th>Camper Name</th>
                    <th>Program</th>
                    <th>Controls</th>
                    <th>Delete?</th>
                </tr>
                </thead>
                <tbody>
                @foreach($campers as $camper)
                    <tr>
                        <td>{{ $camper->familyname }}</td>
                        <td>{{ $camper->lastname }}, {{ $camper->firstname }}</td>
                        <td>{{ $camper->programname }}</td>
                        <td>
                            @include('admin.controls', ['id' => 'c/' . $camper->camperid])
                        </td>
                        <td>
                            <div class="mb-1 btn-group" data-toggle="buttons">
                                <label class="btn btn-primary">
                                    <input type="checkbox" name="{{ $camper->id }}-print" autocomplete="off"/> Print Me
                                </label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Print Nametags']])
        </form>
    </div>
@endsection
