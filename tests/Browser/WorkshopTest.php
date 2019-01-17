<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @group Workshop
 */
class WorkshopTest extends DuskTestCase
{

    public function testDisplay()
    {
        // SetUp
        $year = factory(\App\Year::class)->create();

        $timeslot = factory(\App\Timeslot::class)->create();
        $workshop = factory(\App\Workshop::class)->create(['timeslotid' => $timeslot->id, 'year' => $year->year]);
        $this->browse(function (Browser $browser) use ($timeslot, $workshop) {
            $browser->visit('/workshops')
                ->assertSee($timeslot->name)->assertSee($workshop->name);
        });
    }

    public function testExcursions()
    {
        $year = \App\Year::where('is_current', '1')->first();

        $timeslot = factory(\App\Timeslot::class)->create(['id' => 1005]);
        $excursion = factory(\App\Workshop::class)->create(['timeslotid' => $timeslot->id, 'year' => $year->year]);
        $this->browse(function (Browser $browser) use ($excursion) {
            $browser->visit('/excursions')
                ->assertSee($excursion->name);
        });

        // Teardown
        $year->is_current = 0;
        $year->save();
    }
}
