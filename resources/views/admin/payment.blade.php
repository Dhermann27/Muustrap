@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">{{ $years->first()->first()->family->name }} Statement</div>
            <div class="panel-body">
                <form id="payment" class="form-horizontal" role="form" method="POST"
                      action="{{ url('/payment') . '/' . $years->first()->first()->camperid }}">
                    {{ csrf_field() }}

                    @if(!empty($success))
                        <div class="alert alert-success">
                            {!! $success !!}
                        </div>
                    @endif
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
                                <table class="table table-responsive table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th><label for="chargetypeid">Charge Type</label></th>
                                        <th align="right"><label for="amount">Amount</label></th>
                                        <th align="center"><label for="date">Date</label></th>
                                        <th><label for="memo">Memo</label></th>
                                    </tr>
                                    </thead>
                                    @foreach($charges as $charge)
                                        <tr>
                                            <td>{{ $charge->chargetypename }}</td>
                                            <td class="amount"
                                                align="right">{{ money_format('%.2n', $charge->amount) }}</td>
                                            <td align="center">{{ $charge->timestamp }}</td>
                                            <td>{{ $charge->memo }}</td>
                                        </tr>
                                    @endforeach
                                    @if($loop->last && $readonly === false)
                                        <tr>
                                            <td>
                                                <select class="form-control" id="chargetypeid"
                                                        name="chargetypeid">
                                                    @foreach($chargetypes as $chargetype)
                                                        <option value="{{ $chargetype->id }}"
                                                                {{ $chargetype->id == old('chargetypeid') ? ' selected' : '' }}>
                                                            {{ $chargetype->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    <input type="number" id="amount" class="form-control"
                                                           name="amount" data-number-to-fixed="2"
                                                           value="{{ old('amount') }}"/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group date" data-provide="datepicker"
                                                     data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                                                    <input id="date" type="text" class="form-control"
                                                           name="date" value="{{ old('date') }}" required>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input id="memo" class="form-control" name="memo"
                                                       value="{{ old('memo') }}">
                                            </td>
                                        </tr>
                                    @endif
                                    <tr align="right">
                                        <td><strong>Amount Due:</strong></td>
                                        <td id="amountNow" align="right">
                                            ${{ money_format('%.2n', $charges->sum('amount')) }}
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </table>
                                @if($loop->last && $readonly === false)
                                    <div class="form-group">
                                        <div class="col-md-2 col-md-offset-8">
                                            <button type="submit" class="btn btn-primary">
                                                Save Payment
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="/js/bootstrap-datepicker.min.js"></script>
@endsection
