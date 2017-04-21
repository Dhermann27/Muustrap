@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <h2>Registration Chart</h2>
        </div>
        <div class="row-fluid">
            <div id="chart"></div>
        </div>
        <div class="row">
            <table class="table table-responsive">
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
                @foreach ($summaries as $year)
                    <tr align="center">
                        <td><b>{{ $year->year }}</b></td>
                        <td>+{{ $year->newcampers }}</td>
                        <td>+{{ $year->oldcampers }}</td>
                        <td>+{{ $year->voldcampers }}</td>
                        <td>-{{ $year->lostcampers }}</td>
                        <td>{{ $year->total }}</td>
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
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        var mydata = [
                @foreach($dates as $date => $totals)
            {
                'y': '{{ $date }}',
                @foreach($totals as $year => $total)
                '{{ $year }}':  {{ $total }},
                @endforeach
            },
            @endforeach
        ];
        new Morris.Line({
            element: 'chart',
            data: mydata,
            parseTime: false,
            xkey: 'y',
            ykeys: ['{!! $years->implode("','") !!}'],
            labels: ['{!! $years->implode("','") !!}']
        });
    </script>
@endsection