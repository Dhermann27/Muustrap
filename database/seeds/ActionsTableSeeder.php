<?php

use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = ['read_camperdetails', 'write_camperdetails', 'view_reports',
            'write_staffpositions', 'write_programletters', 'read_disributionlists'];
        array_map(function ($name) {
            DB::table('actions')->insert([
                'name' => $name
            ]);
        }, $actions);
    }
}
