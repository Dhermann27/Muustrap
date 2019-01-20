<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class CamperForm extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return 'form#camperinfo div.tab-content div.tab-pane';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@days' => 'select[name="days[]"',
            '@pronoun' => 'select[name="pronounid[]"]',
            '@first' => 'input[name="firstname[]"]',
            '@last' => 'input[name="lastname[]"]',
            '@email' => 'input[name="email[]"]',
            '@phone' => 'input[name="phonenbr[]"]',
            '@bday' => 'input[name="birthdate[]"]',
            '@prog' => 'select[name="programid[]"]',
            '@room' => 'input[name="roommate[]"]',
            '@spon' => 'input[name="sponsor[]"]',
            '@church' => 'select[name="churchid[]"] + span.select2',
            '@ih' => 'select[name="is_handicap[]"]',
            '@food' => 'select[name="foodoptionid[]"]',
        ];
    }

    public function createCamper($browser, $camper, $ya)
    {

        $browser->select('@days', $ya->days)
            ->select('@pronoun', $camper->pronounid)
            ->type('@first', $camper->firstname)
            ->type('@last', $camper->lastname)
            ->type('@email', $camper->email)
            ->type('@phone', $camper->phonenbr)
            ->keys('@bday', $camper->birthdate)
            ->select('@prog', $ya->programid)
            ->type('@room', $camper->roommate)
            ->type('@spon', $camper->sponsor)
            ->select('@ih', $camper->is_handicap)
            ->select('@food', $camper->foodoptionid)
            ->click('@church');
    }
}
