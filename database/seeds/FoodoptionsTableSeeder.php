<?php

use Illuminate\Database\Seeder;

class FoodoptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foodoptions = [
            'No Restriction',
            'Vegetarian',
            'Vegan',
            'Gluten-Free'
        ];
        array_map ( function ($name) {
            DB::table ( 'foodoptions' )->insert ( [
                'name' => $name
            ] );
        }, $foodoptions );
    }
}
