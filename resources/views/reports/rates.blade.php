@extends('layouts.app')

@section('title')
    Housing Rates
@endsection

@section('content')
    <ul class="nav nav-tabs" role="tablist">
        @foreach($years as $year)
            <li role="presentation"{!! $loop->last ? ' class="active"' : '' !!}>
                <a href="#{{ $year->year }}" aria-controls="{{ $year->year }}" role="tab"
                   data-toggle="tab">{{ $year->year }}</a></li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($years as $year)
            <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' in active' : '' }}"
                 id="{{ $year->year }}">
                @foreach($buildings as $building)
                    <div class="panel-group" id="{{ $year->year }}-accordion" role="tablist"
                         aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab"
                                 id="heading-{{ $year->year }}-{{ $building->id }}">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse"
                                       data-parent="#{{ $year->year }}-accordion"
                                       href="#collapse-{{ $year->year }}-{{ $building->id }}"
                                       aria-controls="collapse-{{ $year->year }}-{{ $building->id }}">
                                        {{ $building->name }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-{{ $year->year }}-{{ $building->id }}"
                                 class="panel-collapse collapse"
                                 role="tabpanel"
                                 aria-labelledby="heading-{{ $year->year }}-{{ $building->id }}">
                                <div class="panel-body">
                                    <table class="table table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th colspan="4"
                                                style="text-align: center; border: 2px dashed black;">
                                                Occupancy
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Program</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4+</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($programs as $program)
                                            <tr>
                                                <?php $rate = $rates->where('programid', $program->id)->where('buildingid', $building->id)->where('start_year', '<=', $year->year)->where('end_year', '>=', $year->year); ?>
                                                <td>{{ $program->name }}</td>
                                                @if(count($rate) > 1)
                                                    @for($i=1; $i<5; $i++)
                                                        <?php $thisrate = $rate->where('min_occupancy', '<=', $i)->where('max_occupancy', '>=', $i); ?>
                                                        @if(count($thisrate) > 0)
                                                            <td>{{ money_format('%.2n', $thisrate->first()->rate*6) }}</td>
                                                        @else
                                                            <td>No Rate</td>
                                                        @endif
                                                    @endfor
                                                @elseif(count($rate) == 1)
                                                    <td colspan="4"
                                                        align="center">{{ money_format('%.2n', $rate->first()->rate*6) }}</td>
                                                @else
                                                    <td colspan="4" align="center">No Rates</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection

