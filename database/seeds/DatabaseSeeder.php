<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BuildingTableSeeder::class);
        $this->call(ChargetypesTableSeeder::class);
        $this->call(FoodoptionsTableSeeder::class);
        $this->call(StatecodesTableSeeder::class);
        $this->call(StaticdatesTableSeeder::class);
    }
}
