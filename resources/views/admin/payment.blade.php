@extends('layouts.app')

@section('title')
    {{ $family->name }} Statement
@endsection

@section('content')
    <div class="container">
        <form id="paymentadmin" class="form-horizontal" role="form" method="POST"
              action="{{ url('/payment/f/' . $family->id) }}">
            @include('snippet.flash')

            <ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
                @foreach($years as $thisyear => $charges)
                    <li role="presentation" class="nav-item">
                        <a href="#{{ $thisyear }}" aria-controls="{{ $thisyear }}" role="tab"
                           class="nav-link{!! $loop->last ? ' active' : '' !!}" data-toggle="tab">
                            {{ $thisyear }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($years as $thisyear => $charges)
                    <div role="tabpanel" class="tab-pane fade{{ $loop->last ? ' active show' : '' }}"
                         aria-expanded="{{ $loop->first ? 'true' : 'false' }}" id="{{ $thisyear }}">
                        <table class="table table-striped table-bordered w-auto">
                            <thead>
                            <tr>
                                <th id="chargetypeid" class="select"><label for="chargetypeid">Charge
                                        Type</label></th>
                                <th id="amount" align="right"><label for="amount">Amount</label></th>
                                <th id="timestamp" align="center"><label for="date">Date</label></th>
                                <th id="memo"><label for="memo">Memo</label></th>
                                @if($readonly === false)
                                    <th>Delete?</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="editable">
                            @foreach($charges as $charge)
                                <tr id="{{ $charge->id }}">
                                    <td>{{ $charge->chargetypename }}</td>
                                    <td class="amount"
                                        align="right">{{ money_format('%.2n', $charge->amount) }}</td>
                                    <td align="center">{{ $charge->timestamp }}</td>
                                    <td>{{ $charge->memo }}</td>
                                    @if($readonly === false)
                                        @if(!empty($charge->timestamp))
                                            <td class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-default">
                                                    <input type="checkbox" name="{{ $charge->id }}-delete"
                                                           autocomplete="off"/> Delete
                                                </label>
                                            </td>
                                        @else
                                            <td>&nbsp;</td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                            @if($loop->last && $readonly === false)
                                <tfoot>
                                <tr>
                                    <td>
                                        <select class="form-control chargetypeid" id="newchargetypeid"
                                                name="chargetypeid">
                                            @foreach($chargetypes as $chargetype)
                                                <option value="{{ $chargetype->id }}"
                                                        {{ $chargetype->id == old('chargetypeid') ? ' selected' : '' }}>
                                                    {{ $chargetype->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="number" id="amount"
                                                   class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                                   step="any" name="amount" data-number-to-fixed="2"
                                                   value="{{ old('amount') }}"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group date" data-provide="datepicker"
                                             data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                                            <input id="date" type="text" class="form-control"
                                                   name="date" value="{{ old('date') }}">
                                            <div class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <input id="memo" class="form-control" name="memo"
                                               value="{{ old('memo') }}">
                                    </td>
                                </tr>
                                @endif
                                <tr align="right">
                                    <td><strong>Balance:</strong></td>
                                    <td id="amountNow" align="right">
                                        ${{ money_format('%.2n', $charges->sum('amount')) }}
                                    </td>
                                    <td colspan="{{ $readonly === false ? '3' : '2' }}">&nbsp;</td>
                                </tr>
                                </tfoot>
                        </table>
                        @if($loop->last && $readonly === false)
                            @include('snippet.formgroup', ['type' => 'submit', 'label' => '', 'attribs' => ['name' => 'Save Changes']])
                        @endif
                    </div>
                @endforeach
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script>
        $("#paymentadmin").on('submit', function (e) {
            var amount = $("#amount");
            if ($("#chargetypeid option:selected").text().includes("Payment") && parseFloat(amount.val()) > 0) {
                var r = confirm("You have entered a positive credit!\nWant me to switch this to negative?");
                if (r) {
                    amount.value = parseFloat(amount.value) * -1;
                }
            }
            return true;
        });
    </script>
@endsection
