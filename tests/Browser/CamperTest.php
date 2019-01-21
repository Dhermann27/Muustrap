<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\CamperForm;
use Tests\DuskTestCase;
use Tests\MailTrap;

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

        $changes = factory(\App\Camper::class)->make(['firstname' => 'Abraham']);
        $cya = factory(\App\Yearattending::class)->make(['year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $camper, $ya, $changes, $cya) {
            $browser->loginAs($user->id)->visit('/camper');
            $browser->within(new CamperForm, function ($browser) use ($camper, $ya, $changes, $cya) {
                $browser->changeCamper([$camper, $ya], [$changes, $cya]);
            })->waitFor('.select2-container--open')
                ->type('span.select2-container input.select2-search__field', substr($changes->church->name, 0, 4))
                ->waitFor('.select2-results__option--highlighted')
                ->click('li.select2-results__option--highlighted')
                ->click('input[type="submit"]')->acceptDialog()
                ->waitFor('div.alert')->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->assertDatabaseHas('campers', ['familyid' => $family->id, 'pronounid' => $changes->pronounid,
            'firstname' => $changes->firstname, 'lastname' => $changes->lastname, 'email' => $changes->email,
            'phonenbr' => $changes->phonenbr, 'birthdate' => $changes->birthdate, 'roommate' => $changes->roommate,
            'sponsor' => $changes->sponsor, 'is_handicap' => $changes->is_handicap,
            'foodoptionid' => $changes->foodoptionid, 'churchid' => $changes->churchid]);
        $this->assertDatabaseHas('yearsattending', ['year' => $year->year, 'programid' => $cya->programid,
            'days' => $cya->days]);

    }

    /**
     * @group Beto
     */
    public function testBeto()
    {
        $year = \App\Year::where('is_current', '1')->first();

        $user = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->create();
        $camper = factory(\App\Camper::class)->create(['firstname' => 'Beto', 'familyid' => $family->id, 'email' => $user->email]);
        $ya = factory(\App\Yearattending::class)->create(['camperid' => $camper->id, 'year' => $year->year]);

        $changes = factory(\App\Camper::class)->make(['firstname' => 'Beto']);
        $cya = factory(\App\Yearattending::class)->make(['year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $camper, $ya, $changes, $cya) {
            $browser->loginAs($user->id)->visit('/camper');
            $browser->within(new CamperForm, function ($browser) use ($camper, $ya, $changes, $cya) {
                $browser->changeCamper([$camper, $ya], [$changes, $cya]);
            })->waitFor('.select2-container--open')
                ->type('span.select2-container input.select2-search__field', substr($changes->church->name, 0, 4))
                ->waitFor('.select2-results__option--highlighted')
                ->click('li.select2-results__option--highlighted')
                ->click('input[type="submit"]')->acceptDialog()
                ->waitFor('div.alert')->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->assertDatabaseHas('users', ['email' => $changes->email]);
        $this->assertDatabaseHas('campers', ['familyid' => $family->id, 'pronounid' => $changes->pronounid,
            'firstname' => $changes->firstname, 'lastname' => $changes->lastname, 'email' => $changes->email,
            'phonenbr' => $changes->phonenbr, 'birthdate' => $changes->birthdate, 'roommate' => $changes->roommate,
            'sponsor' => $changes->sponsor, 'is_handicap' => $changes->is_handicap,
            'foodoptionid' => $changes->foodoptionid, 'churchid' => $changes->churchid]);
        $this->assertDatabaseHas('yearsattending', ['year' => $year->year, 'programid' => $cya->programid,
            'days' => $cya->days]);

    }

    /**
     * @group Charlie
     */
    public function testCharlie()
    {
        $year = \App\Year::where('is_current', '1')->first();

        $user = factory(\App\User::class)->create();
        factory(\App\Role_User::class)->create(['user_id' => $user->id, 'role_id' => \App\Role::where('name', 'admin')->first()->id]);

        $cuser = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->create();
        $camper = factory(\App\Camper::class)->create(['firstname' => 'Charlie', 'familyid' => $family->id, 'email' => $cuser->email]);
        $ya = factory(\App\Yearattending::class)->create(['camperid' => $camper->id, 'year' => $year->year]);

        $changes = factory(\App\Camper::class)->make(['firstname' => 'Charlie']);
        $cya = factory(\App\Yearattending::class)->make(['year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $camper, $ya, $changes, $cya) {
            $browser->loginAs($user->id)->visit('/camper/c/' . $camper->id);
            $browser->within(new CamperForm, function ($browser) use ($camper, $ya, $changes, $cya) {
                $browser->changeCamper([$camper, $ya], [$changes, $cya]);
            })->waitFor('.select2-container--open')
                ->type('span.select2-container input.select2-search__field', substr($changes->church->name, 0, 4))
                ->waitFor('.select2-results__option--highlighted')
                ->click('li.select2-results__option--highlighted')
                ->click('input[type="submit"]')->acceptDialog()
                ->waitFor('div.alert')->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->assertDatabaseHas('users', ['email' => $changes->email]);
        $this->assertDatabaseHas('campers', ['familyid' => $family->id, 'pronounid' => $changes->pronounid,
            'firstname' => $changes->firstname, 'lastname' => $changes->lastname, 'email' => $changes->email,
            'phonenbr' => $changes->phonenbr, 'birthdate' => $changes->birthdate, 'roommate' => $changes->roommate,
            'sponsor' => $changes->sponsor, 'is_handicap' => $changes->is_handicap,
            'foodoptionid' => $changes->foodoptionid, 'churchid' => $changes->churchid]);
        $this->assertDatabaseHas('yearsattending', ['year' => $year->year, 'programid' => $cya->programid,
            'days' => $cya->days]);
    }

    /**
     * @group Charlie
     */
    public function testCharlieRO()
    {
        $year = \App\Year::where('is_current', '1')->first();

        $user = factory(\App\User::class)->create();
        factory(\App\Role_User::class)->create(['user_id' => $user->id, 'role_id' => \App\Role::where('name', 'council')->first()->id]);

        $cuser = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->create();
        $camper = factory(\App\Camper::class)->create(['firstname' => 'Charlie', 'familyid' => $family->id, 'email' => $cuser->email]);
        $ya = factory(\App\Yearattending::class)->create(['camperid' => $camper->id, 'year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $camper, $ya) {
            $browser->loginAs($user->id)->visit('/camper/c/' . $camper->id);
            $browser->within(new CamperForm, function ($browser) use ($camper, $ya) {
                $browser->viewCamper($camper, $ya);
            })->assertMissing('input[type="submit"]');
        });

        // Teardown
$year = \App\Year::where('is_current', '1')->first();
        $year->is_current = 0;
        $year->save();
    }


}
