<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\HouseholdForm;
use Tests\DuskTestCase;

/**
 * @group Household
 */
class HouseholdTest extends DuskTestCase
{

    /**
     * @group Abraham
     */
    public function testAbraham()
    {
        // SetUp
        $year = factory(\App\Year::class)->create();

        $user = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->make();
        $this->browse(function (Browser $browser) use ($user, $family) {
            $browser->loginAs($user->id)->visit('/household')
                ->within(new HouseholdForm, function ($browser) use ($family) {
                    $browser->createHousehold($family);
                });
        });

        $this->assertDatabaseHas('families', ['name' => $family->name, 'address1' => $family->address1,
            'address2' => $family->address2, 'city' => $family->city, 'statecd' => $family->statecd,
            'zipcd' => $family->zipcd, 'country' => $family->country, 'is_ecomm' => $family->is_ecomm,
            'is_scholar' => $family->is_scholar]);

        $changes = factory(\App\Family::class)->make();

        $this->browse(function (Browser $browser) use ($user, $family, $changes) {
            $browser->loginAs($user->id)->visit('/household')
                ->within(new HouseholdForm, function ($browser) use ($family, $changes) {
                    $browser->changeHousehold($family, $changes);
                });
        });

        $this->assertDatabaseHas('families', ['name' => $changes->name, 'address1' => $changes->address1,
            'address2' => $changes->address2, 'city' => $changes->city, 'statecd' => $changes->statecd,
            'zipcd' => $changes->zipcd, 'country' => $changes->country, 'is_ecomm' => $changes->is_ecomm,
            'is_scholar' => $changes->is_scholar]);

    }

    /**
     * @group Beto
     */
    public function testBeto()
    {

        $user = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->create();
        $camper = factory(\App\Camper::class)->create(['familyid' => $family->id, 'firstname' => 'Beto', 'email' => $user->email]);

        $changes = factory(\App\Family::class)->make(['address2' => '', 'country' => '']);

        $this->browse(function (Browser $browser) use ($user, $family, $changes) {
            $browser->loginAs($user->id)->visit('/household')
                ->within(new HouseholdForm, function ($browser) use ($family, $changes) {
                    $browser->changeHousehold($family, $changes);
                });
        });

        $this->assertDatabaseHas('families', ['name' => $changes->name, 'address1' => $changes->address1,
            'address2' => $changes->address2, 'city' => $changes->city, 'statecd' => $changes->statecd,
            'zipcd' => $changes->zipcd, 'country' => $changes->country, 'is_ecomm' => $changes->is_ecomm,
            'is_scholar' => $changes->is_scholar]);

    }

    /**
     * @group Charlie
     */
    public function testCharlie()
    {

        $user = factory(\App\User::class)->create();
        factory(\App\Role_User::class)->create(['user_id' => $user->id, 'role_id' => \App\Role::where('name', 'admin')->first()->id]);

        $family = factory(\App\Family::class)->make(['is_address_current' => rand(0, 1)]);

        $this->browse(function (Browser $browser) use ($user, $family) {
            $browser->loginAs($user->id)->visit('/household/f/0')
                ->within(new HouseholdForm, function ($browser) use ($family) {
                    $browser->select('select#is_address_current', $family->is_address_current)
                        ->createHousehold($family);
                });
        });

        $this->assertDatabaseHas('families', ['name' => $family->name, 'address1' => $family->address1,
            'address2' => $family->address2, 'city' => $family->city, 'statecd' => $family->statecd,
            'zipcd' => $family->zipcd, 'country' => $family->country,
            'is_address_current' => $family->is_address_current, 'is_ecomm' => $family->is_ecomm,
            'is_scholar' => $family->is_scholar]);

        $family = \App\Family::latest()->first();
        $changes = factory(\App\Family::class)->make(['is_address_current' => rand(0, 1)]);

        $this->browse(function (Browser $browser) use ($user, $family, $changes) {
            $browser->loginAs($user->id)->visit('/household/f/' . $family->id)
                ->within(new HouseholdForm, function ($browser) use ($family, $changes) {
                    $browser->assertSelected('select#is_address_current', $family->is_address_current)
                        ->select('select#is_address_current', $changes->is_address_current)
                        ->changeHousehold($family, $changes);
                });
        });

        $this->assertDatabaseHas('families', ['name' => $changes->name, 'address1' => $changes->address1,
            'address2' => $changes->address2, 'city' => $changes->city, 'statecd' => $changes->statecd,
            'zipcd' => $changes->zipcd, 'country' => $changes->country,
            'is_address_current' => $changes->is_address_current, 'is_ecomm' => $changes->is_ecomm,
            'is_scholar' => $changes->is_scholar]);
    }

    /**
     * @group Charlie
     */
    public function testCharlieRO()
    {
        $user = factory(\App\User::class)->create();
        factory(\App\Role_User::class)->create(['user_id' => $user->id, 'role_id' => \App\Role::where('name', 'council')->first()->id]);

        $family = factory(\App\Family::class)->create(['is_address_current' => rand(0, 1)]);
        $this->browse(function (Browser $browser) use ($user, $family) {
            $browser->loginAs($user->id)->visit('/household/f/' . $family->id)
                ->within(new HouseholdForm, function ($browser) use ($family) {
                    $browser->select('select#is_address_current', $family->is_address_current)
                        ->assertDisabled('select#is_address_current')
                        ->viewHousehold($family);
                });
        });


        // Teardown
        $year = \App\Year::where('is_current', '1')->first();
        $year->is_current = 0;
        $year->save();
    }
}
