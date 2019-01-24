<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\CamperForm;
use Facebook\WebDriver\Exception\TimeOutException;
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
     * @throws \Throwable
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
            $browser->loginAs($user->id)->visit('/camper')
                ->waitFor('form#camperinfo div.tab-content div.active');
            $this->createCamper($browser, $camper, $ya);
            $browser->click('input[type="submit"]')->acceptDialog()->waitFor('div.alert')
                ->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->adh($family, $camper);
        $this->assertDatabaseHas('yearsattending', ['programid' => $ya->programid, 'days' => $ya->days]);

        $changes = factory(\App\Camper::class)->make(['firstname' => 'Abraham']);
        $cya = factory(\App\Yearattending::class)->make(['year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $camper, $ya, $changes, $cya) {
            $browser->loginAs($user->id)->visit('/camper')
                ->waitFor('form#camperinfo div.tab-content div.active');
            $this->changeCamper($browser, $camper, $ya, $changes, $cya);
            $browser->click('input[type="submit"]')->acceptDialog()->waitFor('div.alert')->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->adh($family, $changes);
        $this->assertDatabaseHas('yearsattending', ['programid' => $cya->programid, 'days' => $cya->days]);

    }

    /**
     * @group Beto
     * @throws \Throwable
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
            $browser->loginAs($user->id)->visit('/camper')
                ->waitFor('form#camperinfo div.tab-content div.active');
            $this->changeCamper($browser, $camper, $ya, $changes, $cya);
            $browser->click('input[type="submit"]')->acceptDialog()->waitFor('div.alert')
                ->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->assertDatabaseHas('users', ['email' => $changes->email]);
        $this->adh($family, $changes);
        $this->assertDatabaseHas('yearsattending', ['programid' => $cya->programid, 'days' => $cya->days]);

    }

    /**
     * @group Charlie
     * @throws \Throwable
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
            $browser->loginAs($user->id)->visit('/camper/c/' . $camper->id)
                ->waitFor('form#camperinfo div.tab-content div.active');
            $this->changeCamper($browser, $camper, $ya, $changes, $cya);
            $browser->click('input[type="submit"]')->acceptDialog()->waitFor('div.alert')
                ->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        $this->assertDatabaseHas('users', ['email' => $changes->email]);
        $this->adh($family, $changes);
        $this->assertDatabaseHas('yearsattending', ['programid' => $cya->programid, 'days' => $cya->days]);
    }

    /**
     * @group Charlie
     * @throws \Throwable
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
            $browser->loginAs($user->id)->visit('/camper/c/' . $camper->id)
                ->waitFor('form#camperinfo div.tab-content div.active');
            $browser->within(new CamperForm, function ($browser) use ($camper, $ya) {
                $browser->viewCamper($camper, $ya);
            })->assertMissing('input[type="submit"]');
        });


    }

    /**
     * @group Deb
     * @throws \Throwable
     */
    public function testDebDistinct()
    {
        // SetUp
        $year = \App\Year::where('is_current', '1')->first();

        $user = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->create();
        $dummy = new \App\Camper;
        $dummy->familyid = $family->id;
        $dummy->email = $user->email;
        $dummy->save();

        $campers = factory(\App\Camper::class, 2)->make(['email' => $dummy->email]);
        $campers[0]->firstname = "Deb";

        $yas = factory(\App\Yearattending::class, 2)->make(['year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $campers, $yas) {
            $browser->loginAs($user->id)->visit('/camper')
                ->waitFor('form#camperinfo div.tab-content div.active');
            $this->createCamper($browser, $campers[0], $yas[0]);
            $browser->script('window.scrollTo(0,0)');
            $browser->click('a#newcamper')->waitFor('form#camperinfo div.tab-content div.active');
            $this->createCamper($browser, $campers[1], $yas[1]);
            $browser->click('input[type="submit"]')->acceptDialog()->waitFor('div.alert')
                ->assertVisible('div.alert-danger')->assertPresent('span.invalid-feedback');
            $campers[1]->email = 'dan@email.org';
            $browser->script('window.scrollTo(0,0)');
            $browser->pause(250)->clickLink($campers[1]->firstname)
                ->waitFor('form#camperinfo div.tab-content div.active')
                ->type('form#camperinfo div.tab-content div.active input[name="email[]"]', 'dan@email.org');
            $browser->click('input[type="submit"]')->acceptDialog()->waitFor('div.alert')
                ->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        foreach ($campers as $camper) $this->adh($family, $camper);
        foreach ($yas as $ya) {
            $this->assertDatabaseHas('yearsattending', ['programid' => $ya->programid, 'days' => $ya->days]);
        }

        $changes = factory(\App\Camper::class, 2)->make();
        $changes[0]->firstname = "Deb";
        $cyas = factory(\App\Yearattending::class, 2)->make(['year' => $year->year]);

        $this->browse(function (Browser $browser) use ($user, $campers, $yas, $changes, $cyas) {
            $browser->loginAs($user->id)->visit('/camper')
                ->waitFor('form#camperinfo div.tab-content div.active');
            for ($i = 0; $i < count($campers); $i++) {
                $browser->script('window.scrollTo(0,0)');
                $browser->pause(250)->clickLink($campers[$i]->firstname)
                    ->waitFor('form#camperinfo div.tab-content div.active');
                $this->changeCamper($browser, $campers[$i], $yas[$i], $changes[$i], $cyas[$i]);
            }
            $browser->click('input[type="submit"]')->acceptDialog()->waitFor('div.alert')
                ->assertVisible('div.alert-success');
        });

//        PHPUnit::assertTrue($this->messageExists('Confirm'));

        foreach ($changes as $camper) $this->adh($family, $camper);
        foreach ($cyas as $ya) {
            $this->assertDatabaseHas('yearsattending', ['programid' => $ya->programid, 'days' => $ya->days]);
        }

        // Teardown
        $year = \App\Year::where('is_current', '1')->first();
        $year->is_current = 0;
        $year->save();

    }

    /**
     * @throws TimeOutException
     */
    private function createCamper(Browser $browser, $camper, $ya)
    {
        $browser->within(new CamperForm, function ($browser) use ($camper, $ya) {
            $browser->createCamper($camper, $ya);
        })->waitFor('.select2-container--open')
            ->type('span.select2-container input.select2-search__field', substr($camper->church->name, 0, 4))
            ->waitFor('.select2-results__option--highlighted')->click('li.select2-results__option--highlighted');
    }

    private function adh($family, $camper)
    {
        $this->assertDatabaseHas('campers', ['familyid' => $family->id, 'pronounid' => $camper->pronounid,
            'firstname' => $camper->firstname, 'lastname' => $camper->lastname, 'email' => $camper->email,
            'phonenbr' => str_replace('-', '', $camper->phonenbr), 'birthdate' => $camper->birthdate,
            'roommate' => $camper->roommate, 'sponsor' => $camper->sponsor, 'is_handicap' => $camper->is_handicap,
            'foodoptionid' => $camper->foodoptionid, 'churchid' => $camper->churchid]);
    }

    /**
     * @throws TimeOutException
     */
    private function changeCamper(Browser $browser, $camper, $ya, $changes, $cya)
    {
        $browser->within(new CamperForm, function ($browser) use ($camper, $ya, $changes, $cya) {
            $browser->changeCamper([$camper, $ya], [$changes, $cya]);
        })->waitFor('.select2-container--open')
            ->type('span.select2-container input.select2-search__field', substr($changes->church->name, 0, 4))
            ->waitFor('.select2-results__option--highlighted')->click('li.select2-results__option--highlighted');
    }


}
