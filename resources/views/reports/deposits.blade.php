@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Bank Deposits</div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($chargetypes as $chargetype)
                        <li role="presentation"{!! $loop->first? ' class="active"' : '' !!}>
                            <a href="#{{ $chargetype->id }}" aria-controls="{{ $chargetype->id }}" role="tab"
                               data-toggle="tab">{{ $chargetype->name }}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($chargetypes as $chargetype)
                        <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' in active' : '' }}"
                             id="{{ $chargetype->id }}">
                            <div class="panel-group" id="{{ $chargetype->id }}-accordion" role="tablist"
                                 aria-multiselectable="true">
                                @foreach($charges as $ddate => $dcharges)
                                    @if(count($dcharges->filter(function ($value) use ($chargetype) {
                                            return $value->chargetypeid == $chargetype->id;
                                        })) > 0)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab"
                                                 id="heading-{{ $chargetype->id }}-{{ $ddate }}">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse"
                                                       data-parent="#{{ $chargetype->id }}-accordion"
                                                       href="#collapse-{{ $chargetype->id }}-{{ $ddate }}"
                                                       aria-controls="collapse-{{ $chargetype->id }}-{{ $ddate }}">
                                                        {{ empty($ddate) ? 'Undeposited' : $ddate }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapse-{{ $chargetype->id }}-{{ $ddate }}" role="tabpanel"
                                                 class="panel-collapse {{ $loop->first ? '' : 'collapse'}}"
                                                 aria-labelledby="heading-{{ $chargetype->id }}-{{ $ddate }}">
                                                <div class="panel-body">
                                                    <table class="table table-responsive table-condensed">
                                                        <thead>
                                                        <tr>
                                                            <th>Camper Name</th>
                                                            <th>Amount</th>
                                                            <th>Timestamp</th>
                                                            <th>Memo</th>
                                                            <th>Controls</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($dcharges->filter(function ($value) use ($chargetype) {
                                                            return $value->chargetypeid == $chargetype->id;
                                                        }) as $charge)
                                                            <tr>
                                                                <td>{{ $charge->camper->firstname }} {{ $charge->camper->lastname }}</td>
                                                                <td>{{ money_format('$%.2n', abs($charge->amount)) }}</td>
                                                                <td>{{ $charge->timestamp }}</td>
                                                                <td>{{ $charge->memo }}</td>
                                                                <td>
                                                                    @include('admin.controls', ['id' => 'c/' . $charge->camper->id])
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="5" align="right">Total Deposit: {{ money_format('$%.2n', abs($dcharges->filter(function ($value) use ($chargetype) {
                                                            return $value->chargetypeid == $chargetype->id;
                                                        })->sum('amount'))) }}
                                                            </td>
                                                        </tr>
                                                        @role(['admin'])
                                                        @if(empty($ddate))
                                                            <tr>
                                                                <td colspan="5" align="right">
                                                                    <form role="form" method="POST"
                                                                          action="{{ url('/reports/deposits/' . $chargetype->id) }}">
                                                                        {{ csrf_field() }}
                                                                        <div class="form-group">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary">
                                                                                Mark As Deposited
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @endrole
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection

