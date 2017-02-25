@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Registered Campers</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($years as $thisyear => $families)
                        <li role="presentation"{!! $loop->last ? ' class="active"' : '' !!}>
                            <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                               data-toggle="tab">{{ $thisyear }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($years as $thisyear => $families)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' in active' : '' }}"
                             id="{{ $thisyear }}">
                            <table class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>Family</th>
                                    <th>Location</th>
                                </tr>
                                </thead>
                                @foreach($families as $family)
                                    <tr>
                                        <td><a href="{{ url('/household/f/' . $family->id) }}" class="fa fa-home"></a>
                                            <a href="{{ url('/camper/f/' . $family->id) }}" class="fa fa-group"></a>
                                            <a href="{{ url('/payment/f/' . $family->id) }}" class="fa fa-money"></a>
                                            {{ $family->name }}</td>
                                        <td>{{ $family->city }}, {{ $family->statecd }}
                                            @if($family->is_scholar == '1')
                                                <i class="fa fa-universal-access" data-toggle="tooltip"
                                                   title="This family has indicated that they are applying for a scholarship."></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table class="table table-responsive table-condensed">
                                                @foreach($family->campers()->where('year', $thisyear)->orderBy('birthdate')->get() as $camper)
                                                    <tr>
                                                        <td width="25%">{{ $camper->lastname }}
                                                            , {{ $camper->firstname }}</td>
                                                        <td width="25%">{{ $camper->birthdate }}</td>
                                                        <td width="25%">{{ $camper->programname }}</td>
                                                        <td width="25%">{{ $camper->room_number }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

