@extends('layouts.app')

@section('title')
    Housing Rates
@endsection

@section('content')
    @include('snippet.navtabs', ['tabs' => $years, 'id'=> 'year', 'option' => 'year'])

    <div class="tab-content">
        @foreach($years as $year)
            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $year->year }}">
                @component('snippet.accordion', ['id' => $year->year])
                    @foreach($buildings as $building)
                        @component('snippet.accordioncard', ['id' => $year->year, 'loop' => $loop, 'heading' => $building->id, 'title' => $building->name])
                            <table class="table table-striped w-auto">
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
                                        @php
                                            $rate = $rates->where('programid', $program->id)->where('buildingid', $building->id)->where('start_year', '<=', $year->year)->where('end_year', '>', $year->year);
                                        @endphp
                                        <td>{{ $program->name }}</td>
                                        @if(count($rate) > 1)
                                            @for($i=1; $i<5; $i++)
                                                @php
                                                    $thisrate = $rate->where('min_occupancy', '<=', $i)->where('max_occupancy', '>', $i);
                                                @endphp
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
                        @endcomponent
                    @endforeach
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection

