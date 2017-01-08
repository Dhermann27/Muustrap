<?php

namespace App\Http\Controllers;

use Braintree_Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $gateway = new Braintree_Gateway(array(
            'accessToken' => env('PAYPAL_TOKEN')
        ));

        $depositchargetypeid = DB::select('SELECT getchargetypeid(\'MUUSA Deposit\') FROM users');
        $familyid = \App\Camper::where('email', Auth::user()->email)->first()->family->id;
        $charges = \App\Thisyear_Charge::where('familyid', $familyid)->get();
        $deposit = $charges->where('chargetypeid', $depositchargetypeid)->sum('amount');

        return view('payment',
            ['year' => \App\Year::where('is_current', '1')->first(),
                'token' => $gateway->clientToken()->generate(),
                'charges' => $charges, 'deposit' => $deposit]);
    }

    public function store(Request $request)
    {
        $messages = [
            'donation.max' => 'Please use the Contact Us form at the top of the screen (Subject: Treasurer) to commit to a donation above $100.00.',
        ];

        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $this->validate($request, [
            'donation' => 'required|min:0|max:100',
            'amount' => 'required|min:0'
        ], $messages);

        $gateway = new Braintree_Gateway(array(
            'accessToken' => env('PAYPAL_TOKEN')
        ));

        $result = $gateway->transaction()->sale([
            "amount" => $request->amount,
            'merchantAccountId' => 'USD',
            "paymentMethodNonce" => $request->payment_method_nonce,
            "orderId" => $_POST['Mapped to PayPal Invoice Number'],
            "descriptor" => [
                "name" => "Descriptor displayed in customer CC statements. 22 char max"
            ],
            "options" => [
                "paypal" => [
                    "customField" => $_POST["PayPal custom field"],
                    "description" => $_POST["Description for PayPal email receipt"]
                ],
            ]
        ]);
        if ($result->success) {
            $message = array('success' => 'Payment received! You should receive a receipt via email for your records.');
//            print_r("Success ID: " . $result->transaction->id);
        } else {
            $message = array('error' => 'Error. Payment was not processed by MUUSA: ' . $result->message);
        }

        return view('payment',
            ['year' => \App\Year::where('is_current', '1')->first(),
                'token' => $gateway->clientToken()->generate(),
                'charges' =>
                    \App\Thisyear_Charge::where('familyid',
                        \App\Camper::where('email', Auth::user()->email)->first()->family->id)->get()])->with($message);

    }
}
