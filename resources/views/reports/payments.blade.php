@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>
@endsection

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Payments & Credits</div>
            <div class="panel-body">
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
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('table.table').DataTable();
        });
    </script>
@endsection
