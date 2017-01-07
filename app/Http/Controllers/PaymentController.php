<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Braintree_Gateway;

class PaymentController extends Controller
{
    public function index()
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $gateway = new Braintree_Gateway(array(
            'accessToken' => env('PAYPAL_TOKEN')
        ));

        return view('payment',
            ['year' => \App\Year::where('is_current', '1')->first(),
                'token' => $gateway->clientToken()->generate(),
                'charges' =>
                    \App\Thisyear_Charge::where('familyid',
                        \App\Camper::where('email', Auth::user()->email)->first()->family->id)->get()]);
    }

    public function store(Request $request)
    {
        $messages = [
            'donation.max' => 'Please use the Contact Us form at the top of the screen (Subject: Treasurer) to commit to a donation above $100.00.',
        ];

        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $this->validate($request, [
            'donation' => 'required|min:0|max:100'
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
//            print_r("Error Message: " . $result->message);
        }


    }
}
