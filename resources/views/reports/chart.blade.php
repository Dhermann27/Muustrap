@extends('layouts.appstrap')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection

@section('title')
    Registration Chart
@endsection

@section('content')
    <div class="row-fluid">
        <div id="chart"></div>
    </div>
    <table class="table w-80" align="center">
        <tr>
            <th>Year</th>
            <th>New Campers</th>
            <th>Old Campers<br/>1 Year Missing
            </th>
            <th>Very Old Campers<br/>2 or More Years Missing
            </th>
            <th>Campers Lost</th>
            <th>Total</th>
        </tr>
        <tbody>
        @foreach ($summaries as $myyear)
            <tr align="center">
                <td><b>{{ $myyear->year }}</b></td>
                <td>+{{ $myyear->newcampers }}</td>
                <td>+{{ $myyear->oldcampers }}</td>
                <td>+{{ $myyear->voldcampers }}</td>
                <td>-{{ $myyear->lostcampers }}</td>
                <td>{{ $myyear->total }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6" align="center">
                <i>Previous Year's Total - Lost Campers - Total Campers + New Campers
                    + Old Campers + Very Old Campers = 0</i></td>
        </tr>
        </tfoot>
    </table>
@endsection

@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        var years = [
            @foreach($years as $myyear)
                '{{ $myyear->year }}' @if(!$loop->last) , @endif
            @endforeach
        ];
        var mydata = [
                @foreach($dates as $date => $totals)
            {
                'y': '{{ $date }}',
                @foreach($totals as $myyear => $total)
                '{{ $myyear }}':  {{ $total }},
                @endforeach
            },
            @endforeach
        ];
        new Morris.Line({
            element: 'chart',
            data: mydata,
            parseTime: false,
            xkey: 'y',
            ykeys: years,
            labels: years
        });
    </script>
@endsection