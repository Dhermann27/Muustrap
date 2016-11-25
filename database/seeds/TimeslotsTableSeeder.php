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
            'Sunrise' => ['06:30:00', '07:30:00'],
            'Morning' => ['09:50:00', '11:50:00'],
            'Early Afternoon' => ['13:30:00', '15:30:00'],
            'Late Afternoon' => ['16:00:00', '17:30:00'],
            'Evening' => ['19:30:00', '20:30:00'],
            'Excursions' => ['00:00:00', '06:00:00']
        );
        foreach ($timeslots as $name => $times) {
            DB::table('timeslots')->insert([
                'name' => $name,
                'start_time' => $times[0],
                'end_time' => $times[1]
            ]);
        }
    }
}
