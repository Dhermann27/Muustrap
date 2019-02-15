@extends('layouts.appstrap')

@section('title')
    Housing Rates
@endsection

@section('content')
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/reports/rates') }}">
            @include('snippet.flash')

            @component('snippet.navtabs', ['tabs' => $years, 'id'=> 'year', 'option' => 'year'])
                @foreach($years as $year)
                    <div class="tab-pane fade{!! $loop->first ? ' active show' : '' !!}" id="tab-{{ $year->year }}" role="tabpanel">
                        @component('snippet.accordion', ['id' => $year->year])
                            @foreach($buildings as $building)
                                @component('snippet.accordioncard', ['id' => $year->year, 'loop' => $loop, 'heading' => $building->id, 'title' => $building->name])
                                    <table id="rates" class="table table-striped">
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
                                                            $thisrate = $rate->where('min_occupancy', '<=', $i)->where('max_occupancy', '>=', $i);
                                                        @endphp
                                                        @if(count($thisrate) > 0)
                                                            <td id="{{ $thisrate->first()->id }}">{{ money_format('%.2n', $thisrate->first()->rate*6) }}</td>
                                                        @else
                                                            <td>No Rate</td>
                                                        @endif
                                                    @endfor
                                                @elseif(count($rate) == 1)
                                                    <td id="{{ $rate->first()->id }}" colspan="4"
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
            @endcomponent
            @role(['admin'])

            <div class="well">
                <h4>Add New Rate</h4>
                @include('snippet.formgroup', ['type' => 'select',
                    'label' => 'Building', 'attribs' => ['name' => 'buildingid'],
                    'default' => 'Choose a building', 'list' => $buildings, 'option' => 'name'])

                @include('snippet.formgroup', ['type' => 'select',
                    'label' => 'Program', 'attribs' => ['name' => 'programid'],
                    'default' => 'Choose a program', 'list' => $programs, 'option' => 'name'])

                @include('snippet.formgroup', ['label' => 'Minimum Occupancy',
                    'attribs' => ['name' => 'min_occupancy', 'data-number-to-fixed' => '0',
                    'placeholder' => 'Inclusive (2 will apply to 2 occupants)', 'min' => '1']])

                @include('snippet.formgroup', ['label' => 'Maximum Occupancy',
                    'attribs' => ['name' => 'max_occupancy', 'data-number-to-fixed' => '0',
                    'placeholder' => 'Use 999 for unlimited', 'min' => '1']])


                @include('snippet.formgroup', ['label' => 'Rate per Night',
                    'attribs' => ['name' => 'rate', 'data-number-to-fixed' => '8',
                    'placeholder' => 'Divide rate by 6; include repeating decimals', 'min' => '1']])

                <div class="alert alert-warning d-none">
                    Warning: adjusting a rate inline can (and probably will) alter past years of records, depending on
                    the year
                    range of the rate. In order to avoid this, enter a new rate for the same program, building, and
                    occupancy
                    and the old rate will be sunset and a new one will be created for the current year and future years.
                </div>

                @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
            </div>
            @endrole
        </form>
    </div>
@endsection

@section('script')
    @role(['admin'])
    <script>
        $('table#rates tbody td').on('click', function () {
            $(this).html('<input name="' + $(this).attr('id') + '-rate" value="' + parseFloat($(this).text()) / 6 + '" />');
            $(this).off('click');
            $('div.alert-warning').removeClass('d-none');
        });
    </script>
    @endrole
@endsection

