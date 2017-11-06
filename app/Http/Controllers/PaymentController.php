<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        /*$messages = [
            'donation.max' => 'Please use the Contact Us form at the top of the screen (Subject: Treasurer) to commit to a donation above $100.00.',
        ];

        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $this->validate($request, [
            'donation' => 'min:0|max:100',
            'amount' => 'required|min:0'
        ], $messages);*/

        $thiscamper = \App\Camper::where('email', Auth::user()->email)->first();
        if ($thiscamper !== null) {
            if ($request->donation > 0) {
                \App\Charge::updateOrCreate(
                    ['camperid' => $thiscamper->id, 'chargetypeid' => DB::raw('getchargetypeid(\'Donation\')'),
                        'year' => DB::raw('getcurrentyear()')],
                    ['camperid' => $thiscamper->id,
                        'amount' => $request->donation, 'memo' => 'MUUSA Scholarship Fund',
                        'chargetypeid' => DB::raw('getchargetypeid(\'Donation\')'),
                        'year' => DB::raw('getcurrentyear()'), 'timestamp' => date("Y-m-d")]
                );
            }
        }
//        $gateway = new Braintree_Gateway(array(
//            'accessToken' => env('PAYPAL_TOKEN')
//        ));
//
//        $result = $gateway->transaction()->sale([
//            "amount" => $request->amount,
//            'merchantAccountId' => 'USD',
//            "paymentMethodNonce" => $request->nonce,
//            "options" => [
//                "paypal" => [
//                    "description" => "Midwest Unitarian Universalist Summer Assembly fees"
//                ],
//            ]
//        ]);
//
        $success = '';
        $error = '';
        if (!empty($request->txn)) {
            DB::table('charges')->insert(
                ['camperid' => $thiscamper->id, 'amount' => '-' . $request->amount, 'memo' => $request->txn,
                    'chargetypeid' => DB::raw('getchargetypeid(\'Paypal Payment\')'),
                    'year' => DB::raw('getcurrentyear()'), 'timestamp' => date("Y-m-d"),
                    'created_at' => DB::raw('CURRENT_TIMESTAMP')]
            );

            $success = 'Payment received! You should receive a receipt via email for your records.';

            $year = \App\Year::where('is_current', '1')->first();
            $campers = \App\Byyear_Camper::where('familyid', $thiscamper->familyid)
                ->where('year', ((int)$year->year) - 1)->where('is_program_housing', '0')->get();
            if (!$year->isLive() && count($campers) > 0 && \App\Thisyear_Charge::where('familyid', $thiscamper->familyid)
                    ->where(function ($query) {
                        $query->where('chargetypeid', 1003)->orWhere('amount', '<', '0');
                    })->get()->sum('amount') <= 0) {
                foreach ($campers as $camper) {
                    \App\Yearattending::where('camperid', $camper->id)->where('year', $year->year)
                        ->whereNull('roomid')->update(['roomid' => $camper->roomid]);
                }
                DB::statement('CALL generate_charges(' . $year->year . ');');

                $success = 'Payment received! By paying your deposit, your room from ' . ($year->year) - 1
                    . ' has been assigned. You should receive a receipt via email for your records.';
            }


        } else {
            $error = 'Error. Payment was not processed by MUUSA.';
        }

        return $this->index($success, $error);

    }

    public function index($success = null, $error = null)
    {
        $env = env('APP_ENV');

//        setlocale(LC_MONETARY, 'en_US.UTF-8');
//        $gateway = new Braintree_Gateway(array(
//            'accessToken' => env('PAYPAL_TOKEN')
//        ));

        $charges = [];
        $deposit = 0.0;
        $camper = \App\Camper::where('email', Auth::user()->email)->first();
        if ($camper !== null) {
            $depositchargetype = DB::select('SELECT getchargetypeid(\'MUUSA Deposit\') id FROM users');
            $familyid = $camper->family->id;
            $charges = \App\Thisyear_Charge::where('familyid', $familyid)->orderBy('timestamp')->get();
            $deposit = $charges->where('amount', '<', 0)->sum('amount') +
                $charges->where('chargetypeid', $depositchargetype[0]->id)->sum('amount');
        }

        $token = env('PAYPAL_CLIENT');
//        $token = $gateway->clientToken()->generate();
        return view('payment',
            ['token' => $token, 'env' => $env, 'charges' => $charges, 'deposit' => $deposit,
                'success' => $success, 'error' => $error]);
    }

    public function write(Request $request, $id)
    {
        $thiscamper = \App\Camper::where('familyid', $id)->first();
        $year = \App\Year::where('is_current', '1')->first();

        foreach ($request->all() as $key => $value) {
            $matches = array();
            if (preg_match('/(\d+)-(delete|chargetypeid|amount|timestamp|memo)/', $key, $matches)) {
                $charge = \App\Charge::findOrFail($matches[1]);
                if ($matches[2] == 'delete') {
                    if ($value == 'on') {
                        $charge->delete();
                    }
                } else {
                    $charge->{$matches[2]} = $value;
                    $charge->save();
                }
            }
        }

        if ($request->input('amount') != '') {
            $charge = new \App\Charge();
            $charge->camperid = $thiscamper->id;
            $charge->chargetypeid = $request->input('chargetypeid');
            $charge->amount = (float)$request->input('amount');
            $charge->timestamp = $request->input('date');
            $charge->memo = $request->input('memo');
            $charge->year = $year->year;
            $charge->save();
        }

        $success = "";
        if (!$year->isLive() && \App\Thisyear_Charge::where('familyid', $id)->where('chargetypeid', 1003)
                ->orWhere('amount', '<', '0')->get()->sum('amount') <= 0) {
            $campers = \App\Byyear_Camper::where('familyid', $id)->where('year', ((int)$year->year) - 1)
                ->where('is_program_housing', '0')->get();
            foreach ($campers as $camper) {
                \App\Yearattending::where('camperid', $camper->id)->where('year', $year->year)
                    ->whereNull('roomid')->update(['roomid' => $camper->roomid]);
            }
            DB::statement('CALL generate_charges(' . $year->year . ');');

            $success .= 'Your room from ' . ((int)($year->year) - 1) . ' been assigned. ';
        }

        return $this->read('f', $id, $success . 'Rocking it today! But what about their <a href="' . url('/workshopchoice/f/' . $id) . '">workshops</a>?');

    }

    public function read($i, $id, $success = null)
    {
        $readonly = \Entrust::can('read') && !\Entrust::can('write');
        $family = \App\Family::find($this->getFamilyId($i, $id));
        $years = \App\Byyear_Charge::where('familyid', $family->id)
            ->orderBy('year')->orderBy('timestamp')->get()->groupBy('year');

        return view('admin.payment', ['chargetypes' => \App\Chargetype::where('is_shown', '1')->orderBy('name')->get(),
            'years' => $years, 'success' => $success, 'readonly' => $readonly, 'family' => $family]);
    }

    private function getFamilyId($i, $id)
    {
        return $i == 'c' ? \App\Camper::find($id)->familyid : $id;
    }
}