<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class CamperForm extends BaseComponent
{
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
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return 'form#camperinfo div.tab-content div.active';
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
            '@church' => 'select[name="churchid[]"]',
            '@churchs2' => 'select[name="churchid[]"] + span.select2',
            '@ih' => 'select[name="is_handicap[]"]',
            '@food' => 'select[name="foodoptionid[]"]',
        ];
    }

    public function createCamper(Browser $browser, $camper, $ya)
    {
        $browser->select('@days', $ya->days)
            ->select('@pronoun', $camper->pronounid)
            ->type('@first', $camper->firstname)
            ->type('@last', $camper->lastname)
            ->type('@email', $camper->email)
            ->type('@phone', $this->formatPhone($camper->phonenbr))
            ->keys('@bday', $camper->birthdate)
            ->select('@prog', $ya->programid)
            ->type('@room', $camper->roommate)
            ->type('@spon', $camper->sponsor)
            ->select('@ih', $camper->is_handicap)
            ->select('@food', $camper->foodoptionid)
            ->click('@churchs2');
    }

    private function formatPhone($nbr)
    {
        return substr($nbr, 0, 3) . '-' . substr($nbr, 3, 3) . '-' . substr($nbr, 6);
    }

    public function changeCamper(Browser $browser, $from, $to)
    {
        $browser->assertSelected('@days', $from[1]->days)->select('@days', $to[1]->days)
            ->assertSelected('@pronoun', $from[0]->pronounid)->select('@pronoun', $to[0]->pronounid)
            ->assertInputValue('@first', $from[0]->firstname)->type('@first', $to[0]->firstname)
            ->assertInputValue('@last', $from[0]->lastname)->type('@last', $to[0]->lastname)
            ->assertInputValue('@email', $from[0]->email)->type('@email', $to[0]->email)
            ->assertInputValue('@phone', $this->formatPhone($from[0]->phonenbr))->type('@phone', $this->formatPhone($to[0]->phonenbr))
            ->assertInputValue('@bday', $from[0]->birthdate)->clear('@bday')->keys('@bday', $to[0]->birthdate)
            ->assertSelected('@prog', $from[1]->programid)->select('@prog', $to[1]->programid)
            ->assertInputValue('@room', $from[0]->roommate)->type('@room', $to[0]->roommate)
            ->assertInputValue('@spon', $from[0]->sponsor)->type('@spon', $to[0]->sponsor)
            ->assertSelected('@ih', $from[0]->is_handicap)->select('@ih', $to[0]->is_handicap)
            ->assertSelected('@food', $from[0]->foodoptionid)->select('@food', $to[0]->foodoptionid)
            ->assertSelected('@church', $from[0]->churchid)->click('@churchs2');
    }

    public function viewCamper(Browser $browser, $camper, $ya)
    {
        $browser->assertSelected('@days', $ya->days)->assertDisabled('@days')
            ->assertSelected('@pronoun', $camper->pronounid)->assertDisabled('@pronoun')
            ->assertInputValue('@first', $camper->firstname)->assertDisabled('@first')
            ->assertInputValue('@last', $camper->lastname)->assertDisabled('@last')
            ->assertInputValue('@email', $camper->email)->assertDisabled('@email')
            ->assertInputValue('@phone', $this->formatPhone($camper->phonenbr))->assertDisabled('@phone')
            ->assertInputValue('@bday', $camper->birthdate)->assertDisabled('@bday')
            ->assertSelected('@prog', $ya->programid)->assertDisabled('@prog')
            ->assertInputValue('@room', $camper->roommate)->assertDisabled('@room')
            ->assertInputValue('@spon', $camper->sponsor)->assertDisabled('@spon')
            ->assertSelected('@ih', $camper->is_handicap)->assertDisabled('@ih')
            ->assertSelected('@food', $camper->foodoptionid)->assertDisabled('@food')
            ->assertSelected('@church', $camper->churchid);

    }
}
