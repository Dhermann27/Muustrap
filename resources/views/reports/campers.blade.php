@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">{{ $title }}</div>
            <div class="panel-body">
                @if(count($years) > 1)
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($years as $thisyear => $families)
                            <li role="presentation"{!! $loop->last ? ' class="active"' : '' !!}>
                                <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                                   data-toggle="tab">{{ $thisyear }}</a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @endif
                        @foreach($years as $thisyear => $families)
                            <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' in active' : '' }}"
                                 id="{{ $thisyear }}">
                                <table class="table table-responsive table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Family</th>
                                        <th>Location</th>
                                        <th>Controls</th>
                                    </tr>
                                    </thead>
                                    @foreach($families as $family)
                                        <tr>
                                            <td>{{ $family->name }}</td>
                                            <td>{{ $family->city }}, {{ $family->statecd }}
                                                @if($family->is_scholar == '1')
                                                    <i class="fa fa-universal-access" data-toggle="tooltip"
                                                       title="This family has indicated that they are applying for a scholarship."></i>
                                                @endif
                                            </td>
                                            <td>
                                                @include('admin.controls', ['id' => 'f/' . $family->id])
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <table class="table table-responsive table-condensed">
                                                    @foreach(count($years) > 1 ? $family->campers()->where('year', $thisyear)->orderBy('birthdate')->get() : $family->campers as $camper)
                                                        <tr>
                                                            <td width="25%">{{ $camper->lastname }}, {{ $camper->firstname }}
                                                                @if(isset($camper->email))
                                                                    <a href="mailto:{{ $camper->email }}"
                                                                       class="fa fa-envelope"></a>
                                                                @endif
                                                            </td>
                                                            <td width="25%">{{ $camper->birthdate }}</td>
                                                            <td width="25%">{{ $camper->programname }}</td>
                                                            <td width="25%">{{ $camper->room_number }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Total Campers
                                                Attending: </strong> {{ $families->sum('count') }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endforeach
                        @if(count($years) > 1)
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

