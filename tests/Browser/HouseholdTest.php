<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HouseholdTest extends DuskTestCase
{

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testAbraham()
    {
        // SetUp
        $year = factory(\App\Year::class)->create();
        $foodoption = factory(\App\Foodoption::class)->create();
        $church = factory(\App\Church::class)->create(['id' => 2084]);

        $user = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->make();
        $this->browse(function (Browser $browser) use ($user, $family) {
            $browser->loginAs($user->id)->visit('/household')
                ->assertSee('Family Name')
                ->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('name', $family->name)
                ->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('address1', $family->address1)
                ->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('address2', $family->address2)
                ->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('city', $family->city)
                ->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->select('statecd', $family->statecd)
                ->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('zipcd', $family->zipcd)
                ->type('country', $family->country)
                ->select('is_ecomm', $family->is_ecomm)
                ->select('is_scholar', $family->is_scholar)
                ->click('input[type="submit"]')
                ->assertMissing('div.invalid-feedback')->waitFor('div.alert')->assertVisible('div.alert-success');
        });

        $this->assertDatabaseHas('families', ['name' => $family->name, 'address1' => $family->address1,
            'address2' => $family->address2, 'city' => $family->city, 'statecd' => $family->statecd,
            'zipcd' => $family->zipcd, 'country' => $family->country, 'is_ecomm' => $family->is_ecomm,
            'is_scholar' => $family->is_scholar]);

        $changes = factory(\App\Family::class)->make();

        $this->browse(function (Browser $browser) use ($user, $family, $changes) {
            $browser->loginAs($user->id)->visit('/household')
                ->assertSee('Family Name')
                ->assertInputValue('input#name', $family->name)
                ->type('name', $changes->name)
                ->assertInputValue('input#address1', $family->address1)->type('address1', $changes->address1)
                ->assertInputValue('input#address2', $family->address2)->type('address2', $changes->address2)
                ->assertInputValue('input#city', $family->city)->type('city', $changes->city)
                ->assertSelected('select#statecd', $family->statecd)->select('statecd', $changes->statecd)
                ->assertInputValue('input#zipcd', $family->zipcd)->type('zipcd', $changes->zipcd)
                ->assertInputValue('input#country', $family->country)->type('country', $changes->country)
                ->assertSelected('select#is_ecomm', $family->is_ecomm)->select('is_ecomm', $changes->is_ecomm)
                ->assertSelected('select#is_scholar', $family->is_scholar)->select('is_scholar', $changes->is_scholar)
                ->click('input[type="submit"]')
                ->assertMissing('div.invalid-feedback')
                ->waitFor('div.alert')->assertVisible('div.alert-success');
        });

        $this->assertDatabaseHas('families', ['name' => $changes->name, 'address1' => $changes->address1,
            'address2' => $changes->address2, 'city' => $changes->city, 'statecd' => $changes->statecd,
            'zipcd' => $changes->zipcd, 'country' => $changes->country, 'is_ecomm' => $changes->is_ecomm,
            'is_scholar' => $changes->is_scholar]);

    }

    public function testBeto()
    {

        $user = factory(\App\User::class)->create();
        $family = factory(\App\Family::class)->create();
        $camper = factory(\App\Camper::class)->create(['familyid' => $family->id, 'firstname' => 'Beto', 'email' => $user->email]);

        $changes = factory(\App\Family::class)->make(['address2' => '', 'country' => '']);

        $this->browse(function (Browser $browser) use ($user, $family, $changes) {
            $browser->loginAs($user->id)->visit('/household')
                ->assertSee('Family Name')
                ->assertInputValue('input#name', $family->name)
                ->clear('name')->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('name', $changes->name)
                ->assertInputValue('input#address1', $family->address1)
                ->clear('address1')->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('address1', $changes->address1)
                ->assertInputValue('input#address2', $family->address2)->clear('address2')
                ->assertInputValue('input#city', $family->city)
                ->clear('city')->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('city', $changes->city)
                ->assertSelected('select#statecd', $family->statecd)
                ->select('statecd', '0')->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->select('statecd', $changes->statecd)
                ->assertInputValue('input#zipcd', $family->zipcd)
                ->clear('zipcd')->click('input[type="submit"]')->assertVisible('div.invalid-feedback')
                ->type('zipcd', $changes->zipcd)
                ->assertInputValue('input#country', $family->country)->clear('country')
                ->assertSelected('select#is_ecomm', $family->is_ecomm)->select('is_ecomm', $changes->is_ecomm)
                ->assertSelected('select#is_scholar', $family->is_scholar)->select('is_scholar', $changes->is_scholar)
                ->click('input[type="submit"]')
                ->assertMissing('div.invalid-feedback')
                ->waitFor('div.alert')->assertVisible('div.alert-success');
        });

        $this->assertDatabaseHas('families', ['name' => $changes->name, 'address1' => $changes->address1,
            'address2' => $changes->address2, 'city' => $changes->city, 'statecd' => $changes->statecd,
            'zipcd' => $changes->zipcd, 'country' => $changes->country, 'is_ecomm' => $changes->is_ecomm,
            'is_scholar' => $changes->is_scholar]);

    }

    public function testCharlie()
    {

        $user = factory(\App\User::class)->create();
        $role = factory(\App\Role::class)->create(['name' => 'admin']);
        $permissionr = factory(\App\Permission::class)->create(['name' => 'read']);
        $permissionw = factory(\App\Permission::class)->create(['name' => 'write']);
        factory(\App\Permission_Role::class)->create(['permission_id' => $permissionr->id, 'role_id' => $role->id]);
        factory(\App\Permission_Role::class)->create(['permission_id' => $permissionw->id, 'role_id' => $role->id]);
        factory(\App\Role_User::class)->create(['user_id' => $user->id, 'role_id' => $role->id]);

        $family = factory(\App\Family::class)->make(['is_address_current' => rand(0, 1)]);

        $this->browse(function (Browser $browser) use ($user, $family) {
            $browser->loginAs($user->id)->visit('/household/f/0')
                ->assertSee('Family Name')
                ->type('name', $family->name)
                ->type('address1', $family->address1)
                ->type('address2', $family->address2)
                ->type('city', $family->city)
                ->select('statecd', $family->statecd)
                ->type('zipcd', $family->zipcd)
                ->type('country', $family->country)
                ->select('is_address_current', $family->is_address_current)
                ->select('is_ecomm', $family->is_ecomm)
                ->select('is_scholar', $family->is_scholar)
                ->click('input[type="submit"]')
                ->waitFor('div.alert')->assertVisible('div.alert-success');
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
                ->assertSee('Family Name')
                ->assertInputValue('input#name', $family->name)->type('name', $changes->name)
                ->assertInputValue('input#address1', $family->address1)->type('address1', $changes->address1)
                ->assertInputValue('input#address2', $family->address2)->type('address2', $changes->address2)
                ->assertInputValue('input#city', $family->city)->type('city', $changes->city)
                ->assertSelected('select#statecd', $family->statecd)->select('statecd', $changes->statecd)
                ->assertInputValue('input#zipcd', $family->zipcd)->type('zipcd', $changes->zipcd)
                ->assertInputValue('input#country', $family->country)->type('country', $changes->country)
                ->assertSelected('select#is_address_current', $family->is_address_current)->select('is_address_current', $changes->is_address_current)
                ->assertSelected('select#is_ecomm', $family->is_ecomm)->select('is_ecomm', $changes->is_ecomm)
                ->assertSelected('select#is_scholar', $family->is_scholar)->select('is_scholar', $changes->is_scholar)
                ->click('input[type="submit"]')
                ->waitFor('div.alert')->assertVisible('div.alert-success');
        });

        $this->assertDatabaseHas('families', ['name' => $changes->name, 'address1' => $changes->address1,
            'address2' => $changes->address2, 'city' => $changes->city, 'statecd' => $changes->statecd,
            'zipcd' => $changes->zipcd, 'country' => $changes->country,
            'is_address_current' => $changes->is_address_current, 'is_ecomm' => $changes->is_ecomm,
            'is_scholar' => $changes->is_scholar]);
    }

    public function testCharlieRO()
    {
        $user = factory(\App\User::class)->create();
        $role = factory(\App\Role::class)->create(['name' => 'council']);
        $permissionr = \App\Permission::where('name', 'read')->first();
        factory(\App\Permission_Role::class)->create(['permission_id' => $permissionr->id, 'role_id' => $role->id]);
        factory(\App\Role_User::class)->create(['user_id' => $user->id, 'role_id' => $role->id]);

        $family = factory(\App\Family::class)->create(['is_address_current' => rand(0, 1)]);
        $this->browse(function (Browser $browser) use ($user, $family) {
            $browser->loginAs($user->id)->visit('/household/f/' . $family->id)
                ->assertSee('Family Name')->pause(500)
                ->assertInputValue('input#name', $family->name)->assertDisabled('input#name')
                ->assertInputValue('input#address1', $family->address1)->assertDisabled('input#address1')
                ->assertInputValue('input#address2', $family->address2)->assertDisabled('input#address2')
                ->assertInputValue('input#city', $family->city)->assertDisabled('input#city')
                ->assertSelected('select#statecd', $family->statecd)->assertDisabled('select#statecd')
                ->assertInputValue('input#zipcd', $family->zipcd)->assertDisabled('input#zipcd')
                ->assertInputValue('input#country', $family->country)->assertDisabled('input#country')
                ->assertSelected('select#is_address_current', $family->is_address_current)->assertDisabled('select#is_address_current')
                ->assertSelected('select#is_ecomm', $family->is_ecomm)->assertDisabled('select#is_ecomm')
                ->assertSelected('select#is_scholar', $family->is_scholar)->assertDisabled('select#is_scholar')
                ->assertMissing('input[type="submit"]');
        });

        // Teardown
        $year = \App\Year::where('is_current', '1')->first();
        $year->is_current = 0;
        $year->save();
    }
}
