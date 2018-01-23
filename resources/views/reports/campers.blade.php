@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="container">
        @include('snippet.orderby', ['years' => $years, 'url' => url('/reports/campers'), 'orders' => ['name', 'date']])
        <table class="table table-bordered w-auto">
            <thead>
            <tr align="right">
                <td colspan="4"><strong>Total Campers
                        Attending: </strong> {{ $families->sum('count') }}</td>
            </tr>
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
                        <table class="table table-sm w-auto">
                            @foreach($family->campers()->where('year', $thisyear)->get() as $camper)
                                <tr>
                                    <td width="20%">{{ $camper->lastname }}, {{ $camper->firstname }}
                                        @if(isset($camper->email))
                                            <a href="mailto:{{ $camper->email }}" class="px-2 float-right"><i
                                                        class="fa fa-envelope"></i></a>
                                        @endif
                                    </td>
                                    <td width="20%">{{ $camper->birthdate }}
                                        @if(isset($camper->medicalresponse))
                                            <i class="fa fa-pencil-alt"
                                               title="This camper has submitted their medical response."></i>
                                        @endif
                                    </td>
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
    </div>
@endsection

