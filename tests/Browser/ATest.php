<?php

namespace Tests\Browser;

use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Year;

/**
 * @group Welcome
 * @group Camper
 * @group Home
 * @group Household
 * @group Workshop
 */
class ATest extends DuskTestCase
{
    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $app = require __DIR__ . '/../../bootstrap/app.php';

        $kernel = $app->make(\App\Console\Kernel::class);

        $kernel->bootstrap();
        $kernel->call('migrate:refresh');
    }

    public function testWelcomepage()
    {
        $year = factory(Year::class)->create();
        $firstday = Carbon::parse('first Sunday of July ' . $year->year); // TODO: Replace with regexp

        $this->browse(function (Browser $browser) use ($year, $firstday) {
            $browser->visit('/')
                ->assertSee('Midwest Unitarian Universalist Summer Assembly')
                ->assertSeeLink('Register for ' . $year->year)
                ->assertSee('Sunday ' . $firstday->format('F jS') .
                    ' through Saturday July ' . $firstday->addDays(6)->format('jS') . ' ' . $year->year);
        });

        $year = \App\Year::where('is_current', '1')->first();
        $year->is_current = 0;
        $year->save();
    }
}
