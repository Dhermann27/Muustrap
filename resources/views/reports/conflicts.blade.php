@extends('layouts.app')

@section('title')
    Workshop Conflicts
@endsection

@section('content')
    <table class="table w-auto">
        <thead>
        <tr>
            <th>Camper Name</th>
            <th>Conflicting Workshops</th>
            <th>Controls</th>
        </tr>
        </thead>
        <tbody>
        @foreach($campers as $camper)
            <tr>
                <td>{{ $camper->lastname }}, {{ $camper->firstname }}</td>
                <td>{{ $camper->nameone }}, {{ $camper->nametwo }}</td>
                <td>
                    @include('admin.controls', ['id' => 'c/' . $camper->id])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

