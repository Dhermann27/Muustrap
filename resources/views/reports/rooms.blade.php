@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <a href="{{ url('/reports/rooms.xls') }}" class="fa fa-download fa-2x pull-right" data-toggle="tooltip"
               title="Download Rooms Excel"></a>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Room List</div>
            <div class="panel-body">
                @include('snippet.orderby', ['years' => $years, 'orders' => ['name']])
                <input type="hidden" id="orderby-url" value="{{ url('/reports/rooms') }}"/>
                <p>&nbsp;</p>
                @foreach($buildings as $building)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab"
                             id="heading-{{ $building->id }}">
                                            <span class="pull-right">
                                                {{ count($campers->filter(function ($value) use ($building) {
                                                    return $value->buildingid==$building->id && $value->age>17;
                                                })) }}
                                                <i class="fa fa-male"></i>
                                                {{ count($campers->filter(function ($value) use ($building) {
                                                    return $value->buildingid==$building->id && $value->age<=17 && $value->age>5;
                                                })) }}
                                                <i class="fa fa-child"></i>
                                            </span>
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#collapse-{{ $building->id }}"
                                   aria-controls="collapse-{{ $building->id }}">
                                    {{ $building->name }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-{{ $building->id }}"
                             class="panel-collapse collapse"
                             role="tabpanel"
                             aria-labelledby="heading-{{ $building->id }}">
                            <div class="panel-body">
                                <table class="table table-responsive table-condensed">
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
                    </div>
                @endforeach
                <div align="right">
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
                <div align="right">
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
            </div>
        </div>
    </div>
@endsection

