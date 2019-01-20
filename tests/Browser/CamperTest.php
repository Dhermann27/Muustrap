<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\CamperForm;
use Tests\DuskTestCase;
use Tests\MailTrap;
use \PHPUnit\Framework\Assert as PHPUnit;

/**
 * @group Camper
 */
class CamperTest extends DuskTestCase
{
    use MailTrap;

    /**
     * @group Abraham
     */
    public function testAbraham()
    {
        // SetUp
        $year = factory(\App\Year::class)->create();

        $user = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->create();
        $dummy = new \App\Camper;
        $dummy->familyid = $family->id;
        $dummy->email = $user->email;
        $dummy->save();

        $camper = factory(\App\Camper::class)->make(['firstname' => 'Abraham']);
        $ya = factory(\App\Yearattending::class)->make(['year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $camper, $ya) {
            $browser->loginAs($user->id)->visit('/camper');
            $browser->within(new CamperForm, function ($browser) use ($camper, $ya) {
                $browser->createCamper($camper, $ya);
            })->waitFor('.select2-container--open')
                ->type('span.select2-container input.select2-search__field', substr($camper->church->name, 0, 4))
                ->waitFor('.select2-results__option--highlighted')
                ->click('li.select2-results__option--highlighted')
                ->click('input[type="submit"]')->acceptDialog()
                ->waitFor('div.alert')->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->assertDatabaseHas('campers', ['familyid' => $family->id, 'pronounid' => $camper->pronounid,
            'firstname' => $camper->firstname, 'lastname' => $camper->lastname, 'email' => $camper->email,
            'phonenbr' => str_replace('-', '', $camper->phonenbr), 'birthdate' => $camper->birthdate,
            'roommate' => $camper->roommate, 'sponsor' => $camper->sponsor, 'is_handicap' => $camper->is_handicap,
            'foodoptionid' => $camper->foodoptionid, 'churchid' => $camper->churchid]);
        $this->assertDatabaseHas('yearsattending', ['year' => $year->year, 'programid' => $ya->programid,
            'days' => $ya->days]);

    }

    // Teardown
//$year = \App\Year::where('is_current', '1')->first();
//$year->is_current = 0;
//$year->save();
}
