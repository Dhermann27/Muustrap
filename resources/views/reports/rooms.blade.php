@extends('layouts.app')

@section('title')
    Room List
@endsection

@section('content')
    <a href="{{ url('/reports/rooms.xls') }}" class="p-2 float-right" data-toggle="tooltip"
       title="Download Rooms Excel"><i class="fa fa-download fa-2x"></i></a>
    @include('snippet.orderby', ['years' => $years, 'orders' => ['name']])
    <input type="hidden" id="orderby-url" value="{{ url('/reports/rooms') }}"/>
    <p>&nbsp;</p>
    @foreach($buildings as $building)
        <div class="card-accordion" role="tablist" aria-multiselectable="true">
            <div class="card" role="tab" id="heading-{{ $building->id }}">
                <h4 class="card-header">
                <span class="p-3 float-right">
                    {{ count($campers->filter(function ($value) use ($building) {
                        return $value->buildingid==$building->id && $value->age>17;
                    })) }}
                    <i class="fa fa-male"></i>
                    {{ count($campers->filter(function ($value) use ($building) {
                        return $value->buildingid==$building->id && $value->age<=17 && $value->age>5;
                    })) }}
                    <i class="fa fa-child"></i>
                </span>
                    <a {{ $loop->first ? 'class="show" ' : ''}}role="button" data-toggle="collapse"
                       data-parent="#accordion"
                       href="#collapse-{{ $building->id }}"
                       aria-controls="collapse-{{ $building->id }}">
                        {{ $building->name }}
                    </a>
                </h4>
            </div>
            <div id="collapse-{{ $building->id }}" class="in collapse{{ $loop->first ? ' show" ' : ''}}" role="tabpanel"
                 aria-labelledby="heading-{{ $building->id }}">
                <table class="table table-sm w-auto">
                    <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Name</th>
                        <th>Program</th>
                        <th>Age</th>
                        <th>Controls</th>
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
            </div>
        </div>
    @endforeach
    <div class="mt-5 pr-2" align="right">
        <strong>Total Trout Lodge Side: </strong>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 0 && $value->age>17;
        })) }}
        <i class="fa fa-male"></i>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 0 && $value->age<=17 && $value->age>5;
        })) }}
        <i class="fa fa-child"></i>
    </div>
    <div class="mb-5 pr-2" align="right">
        <strong>Total Camp Lakewood Side: </strong>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 2 && $value->age>17;
        })) }}
        <i class="fa fa-male"></i>
        {{ count($campers->filter(function ($value) use ($building) {
            return $value->yearattending->room && $value->yearattending->room->building->side == 2 && $value->age<=17 && $value->age>5;
        })) }}
        <i class="fa fa-child"></i>
    </div>
@endsection

