@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Payment Information</div>
            <div class="panel-body">
                <form id="payment" class="form-horizontal" role="form" method="POST" action="{{ url('/payment') }}">

                    @include('snippet.flash')

                    <table class="table table-responsive table-striped table-bordered">
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
                            <td class="form-group{{ $errors->has('donation') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" id="donation" class="form-control"
                                           step="any" name="donation" data-number-to-fixed="2" min="0"
                                           placeholder="Enter Donation Here"
                                           value="{{ old('donation') }}"/>
                                </div>

                                @if ($errors->has('donation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('donation') }}</strong>
                                    </span>
                                @endif
                            </td>
                            <td colspan='2'>Please consider at least a $10.00 donation to the MUUSA Scholarship fund.
                            </td>
                        </tr>
                        <tr align="right">
                            <td><strong>Amount Due Now:</strong></td>
                            <td id="amountNow" align="right">{{ money_format('%.2n', $deposit) }}
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        @if(!empty($housing))
                            <tr align="right">
                                <td><strong>Amount Due Upon Arrival:</strong></td>
                                <td id="amountArrival">
                                </td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        @endif
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>To Pay via Mail:</h4>
                            Make checks payable to <strong>MUUSA, Inc.</strong><br/>
                            Mail check by May 31, {{ $home->year()->year }} to<br/>
                            MUUSA, Inc.<br/>423 North Waiola<br/>
                            La Grange Park, IL 60526<br/> <br/>
                        </div>
                        <div class="col-md-6">
                            <h4>To Pay via PayPal:</h4>
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="control-label">Suggested Payment:</label>

                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" id="amount"
                                           step="any" class="form-control" name="amount"
                                           data-number-to-fixed="2" min="0" placeholder="Enter Another Amount"
                                           value="{{ number_format(max(count($charges) > 0 ? $charges->sum('amount') : 0.0, 0.0), 2) }}"/>
                                </div>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <p>&nbsp;</p>
                            <div align="right">
                                <input type="hidden" id="txn" name="txn"/>
                                <div id="paypal-button"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script>
        $(document).on('change', '#donation', function () {
            var total = parseFloat($(this).val());
            $("#amount").val(Math.max(0, parseFloat($("#amountNow").text().replace('$', '')) + total).toFixed(2));
            $("td.amount").each(function () {
                total += parseFloat($(this).text().replace('$', ''));
            });
            $("#amountArrival").text("$" + Math.max(0, total).toFixed(2));
        });

        paypal.Button.render({

            env: '{{ $env }}', // Specify 'sandbox' for the test environment

            client: {
        {{ $env }}: '{{ $token }}'
        },

        payment: function () {
            var env    = this.props.env;
            var client = this.props.client;

            return paypal.rest.payment.create(env, client, {
                transactions: [
                    {
                        amount: { total: $("#amount").val(), currency: 'USD' }
                    }
                ]
            });
        },

        commit: true,

            onAuthorize: function (data, actions) {
                $("#txn").val(data.paymentID);
            return actions.payment.execute().then(function(data) {
                $("#payment").submit();
            });

        }

        }, '#paypal-button');
    </script>

@endsection