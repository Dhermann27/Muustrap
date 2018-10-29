<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    protected static $program;
    protected static $buildings = array();
    protected $lodgerates = array();
    protected $lakewoodrates = array();
    protected $tentrates = array();

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

        for ($i = 1; $i < 8; $i++) {
            array_push($this->lodgerates, factory(\App\Rate::class)->create(
                ['buildingid' => 1000, 'programid' => self::$program->id, 'min_occupancy' => $i, 'max_occupancy' => $i]));
            array_push($this->tentrates, factory(\App\Rate::class)->create(
                ['buildingid' => 1007, 'programid' => self::$program->id, 'min_occupancy' => $i, 'max_occupancy' => $i]));
            array_push($this->lakewoodrates, factory(\App\Rate::class)->create(
                ['buildingid' => 1017, 'programid' => self::$program->id, 'min_occupancy' => $i, 'max_occupancy' => $i]));
        }

        $this->browse(function (Browser $browser) {
            $browser->visit('/cost')
                ->assertSee('actual fees may vary');

            $browser->click('@adultup')->assertSee('choose a housing type');

            $browser->select('adults-housing', '1')->assertSee('half the amount shown')
                ->assertSeeIn('div#deposit', 200.00);

            for ($i = 1; $i < 6; $i++) {
                $browser->assertSeeIn('div#adults-fee', money_format('%.2n', $this->lodgerates[0 + min($i - 1, 3)]->rate * 6 * $i));

                $browser->select('adults-housing', '3')
                    ->assertSeeIn('div#adults-fee', money_format('%.2n', $this->lakewoodrates[0]->rate * 6 * $i));

                $browser->select('adults-housing', '4')
                    ->assertSeeIn('div#adults-fee', money_format('%.2n', $this->tentrates[0]->rate * 6 * $i));

                $browser->click('@adultup')->select('adults-housing', '1');
            }

            for ($i = 1; $i < 6; $i++) {
                $browser->click('@kidup')->select('adults-housing', '1')
                    ->assertSeeIn('div#children-fee', money_format('%.2n', $this->lodgerates[4]->rate * 6 * $i));

                $browser->select('adults-housing', '3')
                    ->assertSeeIn('div#children-fee', money_format('%.2n', $this->lakewoodrates[2]->rate * 6 * $i));

                $browser->select('adults-housing', '4')
                    ->assertSeeIn('div#children-fee', money_format('%.2n', $this->tentrates[2]->rate * 6 * $i));

            }

            $browser->click('@yaup')->assertSee('choose a housing type');

            for ($i = 1; $i < 6; $i++) {
                $browser->select('yas-housing', '1')
                    ->assertSeeIn('div#yas-fee', money_format('%.2n', $this->lakewoodrates[6]->rate * 6 * $i));

                $browser->select('yas-housing', '2')
                    ->assertSeeIn('div#yas-fee', money_format('%.2n', $this->tentrates[6]->rate * 6 * $i));

                $browser->click('@yaup');
            }

            for ($i = 1; $i < 6; $i++) {
                $browser->click('@jrup')
                    ->assertSeeIn('div#jrsrs-fee', money_format('%.2n', $this->lakewoodrates[1]->rate * 6 * $i));
            }

            for ($i = 1; $i < 6; $i++) {
                $browser->click('@babyup')
                    ->assertSeeIn('div#babies-fee', money_format('%.2n', $this->lodgerates[6]->rate * 6 * $i));
            }

            $browser->assertSeeIn('div#deposit', 400.00);

        });
    }
}
