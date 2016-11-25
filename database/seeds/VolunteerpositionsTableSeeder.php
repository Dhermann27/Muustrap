<?php

use Illuminate\Database\Seeder;

class VolunteerpositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $volunteers = [
            'Babysitting Co-op',
            'Baggage Assistance',
            'Bookstore',
            'Campwide Service Project',
            'Club Cratty',
            'Coffee House/Karaoke',
            'Morning Celebration',
            'Muse Printing',
            'Newsletter Roving Reporter',
            'Nursery',
            'Opening/Closing Celebration',
            'Registration',
            'St. Vincent',
            'Tour Guide',
            'Vespers'
        ];

        array_map(function ($name) {
            DB::table('volunteerpositions')->insert([
                'name' => $name,
            ]);
        }, $volunteers);
    }
}
