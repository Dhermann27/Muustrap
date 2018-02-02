@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('title')
    Payment Information
@endsection

@section('heading')
    Check back here to see your up-to-date billing statement, and mail via check or send payment online via PayPal.
@endsection

@section('content')
    <div class="container">
        <form id="muusapayment" class="form-horizontal" role="form" method="POST" action="{{ url('/payment') }}">
            @include('snippet.flash')

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Charge Type</th>
                    <th align="right">Amount</th>
                    <th align="center">Date</th>
                    <th>Memo</th>
                </tr>
                </thead>
                @foreach($charges as $charge)
                    <tr>
                        <td>{{ $charge->chargetypename }}</td>
                        <td class="amount" align="right">{{ money_format('%.2n', $charge->amount) }}</td>
                        <td align="center">{{ $charge->timestamp }}</td>
                        <td>{{ $charge->memo }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        <label for="donation" class="control-label">Donation</label>
                    </td>
                    <td class="form-group{{ $errors->has('donation') ? ' has-danger' : '' }}">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                            <input type="number" id="donation"
                                   class="form-control{{ $errors->has('donation') ? ' is-invalid' : '' }}"
                                   step="any" name="donation" data-number-to-fixed="2" min="0"
                                   placeholder="Enter Donation Here"
                                   value="{{ old('donation') }}"/>
                        </div>

                        @if ($errors->has('donation'))
                            <span class="invalid-feedback">
                            <strong>{{ $errors->first('donation') }}</strong>
                        </span>
                        @endif
                    </td>
                    <td colspan='2'>Please consider at least a $10.00 donation to the MUUSA Scholarship fund.
                    </td>
                </tr>
                <tr align="right">
                    <td><strong>Amount Due Now:</strong></td>
                    <td align="right">$<span id="amountNow">{{ money_format('%.2n', max($deposit, 0)) }}</span>
                    </td>
                    <td colspan="2"></td>
                </tr>
                @if(!empty($housing))
                    <tr align="right">
                        <td><strong>Amount Due Upon Arrival:</strong></td>
                        <td>$<span id="amountArrival">{{ money_format('%.2n', max($charges->sum('amount'), 0)) }}</span>
                        </td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                @endif
            </table>
            <div class="row p-7">
                <div class="col-md-6">
                    <h4>To Pay via Mail:</h4>
                    Make checks payable to <strong>MUUSA, Inc.</strong><br/>
                    Mail check by May 31, {{ $home->year()->year }} to<br/>
                    MUUSA, Inc.<br/>423 North Waiola<br/>
                    La Grange Park, IL 60526<br/> <br/>
                </div>
                <div class="col-md-6">
                    <h4>To Pay via PayPal:</h4>
                    <div class="form-group row{{ $errors->has('amount') ? ' has-danger' : '' }}">
                        <label for="amount" class="control-label">Payment:</label>

                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                            <input type="number" id="amount" name="amount"
                                   step="any" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                   data-number-to-fixed="2" min="0" placeholder="Enter Another Amount"
                                   value="{{ money_format('%.2n', max($charges->sum('amount'), 0)) }}"/>
                        </div>

                        <div class="input-group pt-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="addthree" name="addthree"> Add 3% to my payment to cover the PayPal
                                    service fee
                                </label>
                            </div>
                        </div>

                        @if ($errors->has('amount'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                    <input type="hidden" id="txn" name="txn"/>
                    <div id="paypal-button"></div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script>
        $(document).on('change', '#donation', function () {
            var total = parseFloat($(this).val());
            $("#amount").val(Math.max(0, parseFloat($("#amountNow").text()) + total).toFixed(2));
            $("td.amount").each(function () {
                total += parseFloat($(this).text().replace('$', ''));
            });
            $("#amountArrival").text(Math.max(0, total).toFixed(2));
        });

        paypal.Button.render({
            env: '{{ $env }}',
            client: { {{ $env }}: '{{ $token }}'
        },

        style: {
            size: 'large',
            label: 'pay'
        },

        payment: function () {
            var amt = parseFloat($("#amount").val());
            var env = this.props.env;
            var client = this.props.client;
            if ($('input#addthree').is(':checked')) amt *= 1.03;

            return paypal.rest.payment.create(env, client, {
                transactions: [
                    {
                        amount: {total: amt.toFixed(2), currency: 'USD'}
                    }
                ]
            });
        },

        commit: true,

        onAuthorize: function (data, actions) {
            return actions.payment.execute().then(function (payment) {
                if (payment.transactions.length > 0 && payment.transactions[0].related_resources.length > 0) {
                    $("#txn").val(payment.transactions[0].related_resources[0].sale.id);
                }
                $("form#muusapayment").submit();
            });
        }

        }, '#paypal-button');
    </script>

@endsection