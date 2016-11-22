<?php

use Illuminate\Database\Seeder;

class ChargetypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $not_shown = [
            'Carryover Bill',
            'Deposit Applied',
            'Housing Deposit',
            'MUUSA Deposit',
            'MUUSA Fees',
            'Pre-Reg Check Deposit',
            'Pre-Reg Credit Card Deposit',
            'Pre-Reg Paypal Deposit',
            'Staff Credit'];
        $is_shown = [
            'Cash',
            'Check Payment',
            'Credit Card Payment',
            'Early Arrival Fees',
            'Late Fee',
            'MUUSA Donation',
            'MUUSA Scholarship',
            'Other',
            'Paypal Payment',
            'Pre-Registration for Next Year',
            'Refund Issued',
            'Workshop Fee',
            'YMCA Donation',
            'YMCA Scholarship'
        ];
        array_map(function ($name) {
            DB::table('chargetypes')->insert([
                'name' => $name,
                'is_shown' => '0'
            ]);
        }, $not_shown);
        array_map(function ($name) {
            DB::table('chargetypes')->insert([
                'name' => $name,
                'is_shown' => '1'
            ]);
        }, $is_shown);
    }
}
