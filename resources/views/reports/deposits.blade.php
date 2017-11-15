@extends('layouts.app')

@section('title')
    Bank Deposits
@endsection

@section('content')
    @include('snippet.navtabs', ['tabs' => $chargetypes, 'option' => 'name'])

    <div class="tab-content">
        @foreach($chargetypes as $chargetype)
            <div role="tabpanel" class="tab-pane fade{{ $loop->first ? ' active show' : '' }}"
                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $chargetype->id }}">
                <div class="card-accordion" id="{{ $chargetype->id }}-accordion" role="tablist"
                     aria-multiselectable="true">
                    @foreach($charges as $ddate => $dcharges)
                        @if(count($dcharges->filter(function ($value) use ($chargetype) {
                                return $value->chargetypeid == $chargetype->id;
                            })) > 0)
                            <div class="card">
                                <h4 class="card-header py-0 px-0" role="tab">
                                    <a {{ $loop->first ? 'class="show" ' : ''}}role="button" data-toggle="collapse"
                                       data-parent="#{{ $chargetype->id }}-accordion"
                                       href="#collapse-{{ $chargetype->id }}-{{ $ddate }}"
                                       aria-controls="collapse-{{ $chargetype->id }}-{{ $ddate }}">
                                        {{ empty($ddate) ? 'Undeposited' : $ddate }}
                                    </a>
                                </h4>
                                <div id="collapse-{{ $chargetype->id }}-{{ $ddate }}" role="tabpanel"
                                     class="in collapse{{ $loop->first ? ' show' : ''}}"
                                     aria-labelledby="heading-{{ $chargetype->id }}-{{ $ddate }}">
                                    <div class="panel-body">
                                        <table class="table table-sm w-auto">
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
                                                    <td>{{ money_format('$%.2n', $charge->amount) }}</td>
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
@endsection

