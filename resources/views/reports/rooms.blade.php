@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Room List</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($years as $thisyear => $campers)
                        <li role="presentation"{!! $loop->last ? ' class="active"' : '' !!}>
                            <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                               data-toggle="tab">{{ $thisyear }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($years as $thisyear => $campers)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' in active' : '' }}"
                             id="{{ $thisyear }}">
                            <div class="panel-group" id="{{ $thisyear }}-accordion" role="tablist"
                                 aria-multiselectable="true">
                                @foreach($buildings as $building)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab"
                                             id="heading-{{ $thisyear }}-{{ $building->id }}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#{{ $thisyear }}-accordion"
                                                   href="#collapse-{{ $thisyear }}-{{ $building->id }}"
                                                   aria-controls="collapse-{{ $thisyear }}-{{ $building->id }}">
                                                    {{ $building->name }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse-{{ $thisyear }}-{{ $building->id }}"
                                             class="panel-collapse collapse"
                                             role="tabpanel"
                                             aria-labelledby="heading-{{ $thisyear }}-{{ $building->id }}">
                                            <div class="panel-body">
                                                <table class="table table-responsive table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th>Room Number</th>
                                                        <th>Name</th>
                                                        <th>Program</th>
                                                        <th>Birthdate</th>
                                                        <th>Controls</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($campers->where('year', $thisyear)->where('buildingid', $building->id) as $camper)
                                                        <tr>
                                                            <td>{{ $camper->room_number }}</td>
                                                            <td>{{ $camper->firstname }} {{ $camper->lastname }}</td>
                                                            <td>{{ $camper->programname }}</td>
                                                            <td>{{ $camper->birthdate }}</td>
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
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection

