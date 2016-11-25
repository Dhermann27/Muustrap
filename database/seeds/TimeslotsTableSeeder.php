<?php

use Illuminate\Database\Seeder;

class TimeslotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeslots = array(
            'Sunrise' => ['SR', '06:30:00', '07:30:00'],
            'Morning' => ['M', '09:50:00', '11:50:00'],
            'Early Afternoon' => ['EA', '13:30:00', '15:30:00'],
            'Late Afternoon' => ['LA', '16:00:00', '17:30:00'],
            'Evening' => ['SS', '19:30:00', '20:30:00'],
            'Excursions' => ['EX', '00:00:00', '06:00:00']
        );
        foreach ($timeslots as $name => $info) {
            DB::table('timeslots')->insert([
                'name' => $name,
                'code' => $info[0],
                'start_time' => $info[1],
                'end_time' => $info[2]
            ]);
        }
    }
}
