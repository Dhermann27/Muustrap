<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WorkshopTest extends DuskTestCase
{

    public function testDisplay()
    {
        // SetUp
        $year = factory(\App\Year::class)->create();

        $timeslot = factory(\App\Timeslot::class)->create();
        $building = factory(\App\Building::class)->create();
        $room = factory(\App\Room::class)->create(['buildingid' => $building->id]);
        $workshops = factory(\App\Workshop::class, 10)->create(['timeslotid' => $timeslot->id, 'roomid' => $room->id, 'year' => $year->thisyear]);
        $this->browse(function (Browser $browser) use ($timeslot, $workshops) {
            $browser->visit('/workshops')
                ->assertSee($timeslot->name)->assertSee($workshops[rand(0, 9)]->name);
        });
    }

    public function testExcursions()
    {
        $year = \App\Year::where('is_current', '1')->first();

        $timeslot = factory(\App\Timeslot::class)->create(['id' => 1005]);
        $building = factory(\App\Building::class)->create();
        $room = factory(\App\Room::class)->create(['buildingid' => $building->id]);
        $excursion = factory(\App\Workshop::class)->create(['timeslotid' => $timeslot->id, 'roomid' => $room->id, 'year' => $year->thisyear]);
        $this->browse(function (Browser $browser) use ($excursion) {
            $browser->visit('/excursions')
                ->assertSee($excursion->name);
        });

        // Teardown
        $year->is_current = 0;
        $year->save();
    }
}
