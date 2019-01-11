<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{

    public function testPrograms()
    {
        // SetUp
        $year = factory(\App\Year::class)->create();

        $program = factory(\App\Program::class)->create();

        $this->browse(function (Browser $browser) use ($program) {
            $browser->visit('/programs')
                ->assertSee($program->name);
        });
    }

    public function testHousing()
    {
        $building = factory(\App\Building::class)->create(['id' => 1000]);

        $this->browse(function (Browser $browser) use ($building) {
            $browser->visit('/housing')
                ->assertSee($building->name);
        });
    }

    public function testRegistration()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/registration')
                ->assertSee('Household'); // TODO: Move to end-to-end test
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
        $program = factory(\App\Program::class)->create();
        $buildings = array();
        $lodgerates = array();
        $lakewoodrates = array();
        $tentrates = array();

        array_push($buildings, \App\Building::find('1000'));
        array_push($buildings, factory(\App\Building::class)->create(['id' => 1007]));
        array_push($buildings, factory(\App\Building::class)->create(['id' => 1017]));

        for ($i = 1; $i < 8; $i++) {
            array_push($lodgerates, factory(\App\Rate::class)->create(
                ['buildingid' => $buildings[0]->id, 'programid' => $program->id, 'min_occupancy' => $i, 'max_occupancy' => $i]));
            array_push($tentrates, factory(\App\Rate::class)->create(
                ['buildingid' => $buildings[1]->id, 'programid' => $program->id, 'min_occupancy' => $i, 'max_occupancy' => $i]));
            array_push($lakewoodrates, factory(\App\Rate::class)->create(
                ['buildingid' => $buildings[2]->id, 'programid' => $program->id, 'min_occupancy' => $i, 'max_occupancy' => $i]));
        }

        $this->browse(function (Browser $browser) use($lodgerates, $lakewoodrates, $tentrates) {
            $browser->visit('/cost')
                ->assertSee('actual fees may vary');

            $browser->click('@adultup')->assertSee('choose a housing type');

            $browser->select('adults-housing', '1')->assertSee('half the amount shown')
                ->assertSeeIn('span#deposit', 200.00);

            for ($i = 1; $i < 6; $i++) {
                $browser->assertSeeIn('div#adults-fee', money_format('%.2n', $lodgerates[0 + min($i - 1, 3)]->rate * 6 * $i));

                $browser->select('adults-housing', '3')
                    ->assertSeeIn('div#adults-fee', money_format('%.2n', $lakewoodrates[0]->rate * 6 * $i));

                $browser->select('adults-housing', '4')
                    ->assertSeeIn('div#adults-fee', money_format('%.2n', $tentrates[0]->rate * 6 * $i));

                $browser->click('@adultup')->select('adults-housing', '1');
            }

            for ($i = 1; $i < 6; $i++) {
                $browser->click('@kidup')->select('adults-housing', '1')
                    ->assertSeeIn('div#children-fee', money_format('%.2n', $lodgerates[4]->rate * 6 * $i));

                $browser->select('adults-housing', '3')
                    ->assertSeeIn('div#children-fee', money_format('%.2n', $lakewoodrates[2]->rate * 6 * $i));

                $browser->select('adults-housing', '4')
                    ->assertSeeIn('div#children-fee', money_format('%.2n', $tentrates[2]->rate * 6 * $i));

            }

            $browser->click('@yaup')->assertSee('choose a housing type');

            for ($i = 1; $i < 6; $i++) {
                $browser->select('yas-housing', '1')
                    ->assertSeeIn('div#yas-fee', money_format('%.2n', $lakewoodrates[6]->rate * 6 * $i));

                $browser->select('yas-housing', '2')
                    ->assertSeeIn('div#yas-fee', money_format('%.2n', $tentrates[6]->rate * 6 * $i));

                $browser->click('@yaup');
            }

            for ($i = 1; $i < 6; $i++) {
                $browser->click('@jrup')
                    ->assertSeeIn('div#jrsrs-fee', money_format('%.2n', $lakewoodrates[1]->rate * 6 * $i));
            }

            for ($i = 1; $i < 6; $i++) {
                $browser->click('@babyup')
                    ->assertSeeIn('div#babies-fee', money_format('%.2n', $lodgerates[6]->rate * 6 * $i));
            }

            $browser->assertSeeIn('span#deposit', 400.00);

        });

        // Teardown
        $year = \App\Year::where('is_current', '1')->first();
        $year->is_current = 0;
        $year->save();
    }
}
