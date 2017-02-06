<?php

namespace App\Http\Controllers;

use Braintree_Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'donation.max' => 'Please use the Contact Us form at the top of the screen (Subject: Treasurer) to commit to a donation above $100.00.',
        ];

        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $this->validate($request, [
            'donation' => 'min:0|max:100',
            'amount' => 'required|min:0'
        ], $messages);

        $camper = \App\Camper::where('email', Auth::user()->email)->first();
        if ($camper !== null) {
            if ($request->donation > 0) {
                \App\Charge::updateOrCreate(
                    ['camperid' => $camper->id, 'chargetypeid' => DB::raw('getchargetypeid(\'Donation\')'),
                        'year' => DB::raw('getcurrentyear()')],
                    ['camperid' => $camper->id,
                        'amount' => $request->donation, 'memo' => 'MUUSA Scholarship Fund',
                        'chargetypeid' => DB::raw('getchargetypeid(\'Donation\')'),
                        'year' => DB::raw('getcurrentyear()'), 'timestamp' => date("Y-m-d")]
                );
            }
        }
        $gateway = new Braintree_Gateway(array(
            'accessToken' => env('PAYPAL_TOKEN')
        ));

        $result = $gateway->transaction()->sale([
            "amount" => $request->amount,
            'merchantAccountId' => 'USD',
            "paymentMethodNonce" => $request->nonce,
            "options" => [
                "paypal" => [
                    "description" => "Midwest Unitarian Universalist Summer Assembly fees"
                ],
            ]
        ]);

        $success = '';
        $error = '';
        if ($result->success) {
            DB::table('charges')->insert(
                ['camperid' => $camperid, 'amount' => '-' . $request->amount, 'memo' => $result->transaction->id,
                    'chargetypeid' => DB::raw('getchargetypeid(\'Paypal Payment\')'),
                    'year' => DB::raw('getcurrentyear()'), 'timestamp' => date("Y-m-d"),
                    'created_at' => DB::raw('CURRENT_TIMESTAMP')]
            );

            $success = 'Payment received! You should receive a receipt via email for your records.';
        } else {
            $error = 'Error. Payment was not processed by MUUSA: ' . $result->message;
        }

        return $this->index($success, $error);

    }

    public function index($success = null, $error = null)
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $gateway = new Braintree_Gateway(array(
            'accessToken' => env('PAYPAL_TOKEN')
        ));

        $charges = [];
        $deposit = 0.0;
        $camper = \App\Camper::where('email', Auth::user()->email)->first();
        if ($camper !== null) {
            $depositchargetype = DB::select(DB::raw('SELECT getchargetypeid(\'MUUSA Deposit\') FROM users'));
            $familyid = $camper->family->id;
            $charges = \App\Thisyear_Charge::where('familyid', $familyid)->orderBy('timestamp')->get();
            $deposit = $charges->where('chargetypeid', $depositchargetype)->sum('amount');
        }

        $token = $gateway->clientToken()->generate();
        return view('payment',
            ['year' => \App\Year::where('is_current', '1')->first(),
                'token' => $token,
                'charges' => $charges, 'deposit' => $deposit, 'success' => $success, 'error' => $error]);
    }
}
