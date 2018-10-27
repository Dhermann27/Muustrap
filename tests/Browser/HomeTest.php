<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    protected static $program;
    protected static $buildings = array();

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$program = factory(\App\Program::class)->create();
        array_push(self::$buildings, factory(\App\Building::class)->create(['id' => 1000]));
        array_push(self::$buildings, factory(\App\Building::class)->create(['id' => 1007]));
        array_push(self::$buildings, factory(\App\Building::class)->create(['id' => 1017]));
    }

    public function testPrograms()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/programs')
                ->assertSee(self::$program->name);
        });
    }

    public function testHousing()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/housing')
                ->assertSee(self::$buildings[0]->name);
        });
    }

    public function testScholarship()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/scholarship')
                ->assertSee('financial assistance');
        });
    }

    public function testThemeSpeakers()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/themespeaker')
                ->assertSee('Rev');
        });
    }

    public function testCampCost()
    {
        $rates = array();

        foreach (self::$buildings as $building) {
            for ($i = 1; $i < 7; $i++) {
                array_push($rates, factory(\App\Rate::class)->create(
                    ['buildingid' => $building->id, 'programid' => self::$program->id,
                        'min_occupancy' => $i, 'max_occupancy' => $i]));
            }
        }

        $this->browse(function (Browser $browser) {
            $browser->visit('/cost')
                ->assertSee('actual fees may vary');

            $browser->click('@adultup')->assertSee('choose a housing type');
        });
    }
}
