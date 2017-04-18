@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs/dt-1.10.13/b-1.2.4/b-html5-1.2.4/b-print-1.2.4/r-2.1.1/datatables.min.css"/>
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Payments & Credits</div>
            <div class="panel-body">
                <label class="control-label visible-print" for="fini">From:</label>
                <div class="input-group input-daterange">
                    <input type="text" id="fini" class="form-control"/>
                    <span class="input-group-addon">to</span>
                    <input type="text" id="ffin" class="form-control">
                </div>
                <label class="control-label visible-print" for="ffin">To:</label>
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($years as $thisyear => $charges)
                        <li role="presentation"{!! $loop->last ? ' class="active"' : '' !!}>
                            <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                               data-toggle="tab">{{ $thisyear }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($years as $thisyear => $charges)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' in active' : '' }}"
                             id="{{ $thisyear }}">
                            <div class="panel-group" id="{{ $thisyear }}-accordion" role="tablist"
                                 aria-multiselectable="true">
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Family Name</th>
                                            <th>Camper Name</th>
                                            <th>Chargetype</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Memo</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Family Name</th>
                                            <th>Camper Name</th>
                                            <th>Chargetype</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Memo</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($charges as $charge)
                                            <tr>
                                                <td>{{ $charge->family->name }}</td>
                                                <td>{{ $charge->camper->lastname }}
                                                    , {{ $charge->camper->firstname }}</td>
                                                <td>{{ $charge->chargetypename }}</td>
                                                <td>{{ money_format('%.2n', $charge->amount) }}</td>
                                                <td>{{ $charge->timestamp }}</td>
                                                <td>{{ $charge->memo }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript"
            src="//cdn.datatables.net/v/bs/dt-1.10.13/b-1.2.4/b-html5-1.2.4/b-print-1.2.4/r-2.1.1/datatables.min.js"></script>
    <script type="text/javascript"
            src="/js/range_dates.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('table.table').DataTable({
                buttons: [
                    'csv'
                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }
            });
            $('div.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            }).on('changeDate', function (e) {
                table.draw();
            });
        });
    </script>
@endsection
