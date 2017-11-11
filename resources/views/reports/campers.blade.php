@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        <a href="{{ url('/reports/campers.xls') }}" class="fa fa-download fa-2x pull-right" data-toggle="tooltip"
           title="Download Campers Excel"></a>
    </div>
    @include('snippet.orderby', ['years' => $years, 'orders' => ['name', 'date']])
    <input type="hidden" id="orderby-url" value="{{ url('/reports/campers') }}"/>
    <table class="table table-responsive table-bordered">
        <caption style="text-align:right;"><strong>Total Campers
                Attending: </strong> {{ $families->sum('count') }}</caption>
        <thead>
        <tr>
            <th>Family</th>
            <th>Location</th>
            <th>Balance</th>
            <th>Registration Date</th>
        </tr>
        </thead>
        @foreach($families as $family)
            <tr>
                <td>{{ $family->name }}</td>
                <td>{{ $family->city }}, {{ $family->statecd }}</td>
                <td>${{ money_format('%.2n', $family->balance) }}
                    @if($family->is_scholar == '1')
                        <i class="fa fa-universal-access" data-toggle="tooltip"
                           title="This family has indicated that they are applying for a scholarship."></i>
                    @endif
                </td>
                <td>{{ $family->created_at->toDateString() }}</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="table table-responsive table-condensed">
                        @foreach($family->campers()->where('year', $thisyear)->get() as $camper)
                            <tr>
                                <td width="20%">{{ $camper->lastname }}, {{ $camper->firstname }}
                                    @if(isset($camper->email))
                                        <a href="mailto:{{ $camper->email }}"
                                           class="fa fa-envelope"></a>
                                    @endif
                                </td>
                                <td width="20%">{{ $camper->birthdate }}</td>
                                <td width="20%">{{ $camper->programname }}</td>
                                <td width="20%">{{ $camper->room_number }}</td>
                                <td width="20%">
                                    @include('admin.controls', ['id' => 'c/' . $camper->id])
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
        <tfoot>
        <tr>
            <td colspan="4" align="right"><strong>Total Campers
                    Attending: </strong> {{ $families->sum('count') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection

