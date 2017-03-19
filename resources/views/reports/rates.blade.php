@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Housing Rates</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($programs as $program)
                        <li role="presentation"{!! $loop->first ? ' class="active"' : '' !!}>
                            <a href="#{{ $program->id }}" aria-controls="{{ $program->id }}" role="tab"
                               data-toggle="tab">{{ $program->name }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($programs as $program)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                             id="{{ $program->id }}">
                            <div class="panel-group" id="{{ $program->id }}-accordion" role="tablist"
                                 aria-multiselectable="true">
                                <table class="table table-responsive table-striped">
                                    <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th colspan="4" style="text-align: center; border: 2px dashed black;">
                                            Occupancy
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Building</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4+</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($buildings as $building)
                                        <tr>
                                            <td>{{ $building->name }}</td>
                                            <?php $rate = $rates->where('programid', $program->id)->where('buildingid', $building->id); ?>
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
                                                <td colspan="4" align="center">{{ money_format('%.2n', $rate->first()->rate*6) }}</td>
                                            @else
                                                <td colspan="4" align="center">No Rates</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

