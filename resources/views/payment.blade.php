@extends('layouts.app')

@section('content')
    <p>&nbsp;</p>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Payment Information</div>
            <div class="panel-body">
                <form id="payment" class="form-horizontal" role="form" method="POST" action="{{ url('/payment') }}">
                    {{ csrf_field() }}

                    @if (!empty($success))
                        <div class="alert alert-success">
                            {{ $success }}
                        </div>
                    @elseif(!empty($error))
                        <div class="alert alert-error">
                            {{ $success }}
                        </div>
                    @endif
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
                                <td align=" right">{{ money_format('%.2n', $charge->amount) }}</td>
                                <td align="center">{{ $charge->timestamp }}</td>
                                <td>{{ $charge->memo }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>
                                <label for="donation" class="control-label">Donation</label>
                            </td>
                            <td align="right">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" id="donation" class="form-control"
                                           data-number-to-fixed="2" min="0" name="donation"
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
                            Mail check by May 31, {{ $year->year }} to<br/>
                            MUUSA, Inc.<br/>423 North Waiola<br/>
                            La Grange Park, IL 60526<br/> <br/>
                        </div>
                        <div class="col-md-6">
                            <h4>To Pay via PayPal:</h4>
                            <div>
                                <label for="amount" class="control-label">Suggested Payment:</label>

                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" id="amount"
                                           class="form-control" name="amount"
                                           data-number-to-fixed="2" min="0" placeholder="Enter Another Amount"
                                           value="{{ number_format(max($charges->sum('amount'), 0.0), 2) }}"/></div>
                            </div>
                            <p>&nbsp;</p>
                            <div align="right">
                                <script src="https://js.braintreegateway.com/web/3.6.3/js/client.min.js"></script>
                                <script src="https://js.braintreegateway.com/web/3.6.3/js/paypal.min.js"></script>
                                <script>
                                    braintree.client.create({
                                        authorization: '{{ $token }}'
                                    }, function (clientErr, clientInstance) {
                                        // Create PayPal component
                                        braintree.paypal.create({
                                            client: clientInstance
                                        }, function (err, paypalInstance) {
                                            $("#paypalButton").on('click', function () {
                                                paypalInstance.tokenize({
                                                    flow: 'checkout', // Required
                                                    amount: $("#amount"), // Required
                                                    currency: 'USD', // Required
                                                    locale: 'en_US',
                                                    enableShippingAddress: false
                                                }, function (err, tokenizationPayload) {
                                                    $("#nonce").val(tokenizationPayload.nonce);
                                                    $("#payment").submit();
                                                });
                                            });
                                        });
                                    });

                                </script>
                                <input type="hidden" id="nonce"/>
                                <script src="https://www.paypalobjects.com/api/button.js?"
                                        data-merchant="braintree"
                                        data-id="paypalButton"
                                        data-button="checkout"
                                        data-color="blue"
                                        data-size="medium"
                                        data-shape="rect"
                                        data-button_type="submit"
                                        data-button_disabled="false"
                                ></script>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
            <script src="/js/payment.js" type="text/javascript"></script>
        </div>
    </div>
@endsection