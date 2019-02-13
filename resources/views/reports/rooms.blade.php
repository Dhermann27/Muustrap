@extends('layouts.appstrap')

@section('title')
    Room List
@endsection

@section('content')
    @include('snippet.orderby', ['years' => $years, 'url' => url('/reports/rooms'), 'orders' => ['name']])
    <p>&nbsp;</p>
    @component('snippet.accordion', ['id' => ''])
        @foreach($buildings as $building)
            @component('snippet.accordioncard', ['id' => '1', 'loop' => $loop, 'heading' => $building->id, 'title' => $building->name])
                @slot('badge')
                    <span class="badge badge-primary">
                    {{ count($campers->filter(function ($value) use ($building) {
                        return $value->buildingid==$building->id && $value->age>17;
                    })) }}
                        <i class="far fa-male"></i>
                        {{ count($campers->filter(function ($value) use ($building) {
                            return $value->buildingid==$building->id && $value->age<=17 && $value->age>5;
                        })) }}
                        <i class="far fa-child"></i>
                </span>
                @endslot
                <table class="table">
                    <thead>
                    <tr>
                        <th width="10%">Room Number</th>
                        <th width="40%">Name</th>
                        <th width="30%">Program</th>
                        <th width="10%">Age</th>
                        <th width="10%">Controls</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($campers->filter(function ($value) use ($building) {
                        return $value->buildingid==$building->id;
                    }) as $camper)
                        <tr>
                            <td>{{ $camper->room_number }}</td>
                            <td>{{ $camper->lastname }}, {{ $camper->firstname }}</td>
                            <td>{{ $camper->programname }}</td>
                            <td>{{ $camper->age }}</td>
                            <td>
                                @include('admin.controls', ['id' => 'c/' . $camper->id])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        @endforeach
    @endcomponent
    <div class="mt-5 pr-2" align="right">
        <strong>Total Trout Lodge Side: </strong>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 0 && $value->age>17;
        })) }}
        <i class="far fa-male"></i>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 0 && $value->age<=17 && $value->age>5;
        })) }}
        <i class="far fa-child"></i>
    </div>
    <div class="mb-5 pr-2" align="right">
        <strong>Total Camp Lakewood Side: </strong>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 2 && $value->age>17;
        })) }}
        <i class="far fa-male"></i>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 2 && $value->age<=17 && $value->age>5;
        })) }}
        <i class="far fa-child"></i>
    </div>
@endsection

