<?php

class MuusaTest extends TestCase
{
    public function testHomepage()
    {
        $this->visit('/')->see('MUUSA');
    }

    public function testContactUs()
    {
        $this->visit('/contact')->see('Technical Support');
    }

    public function testSendContactUs()
    {
        $good = ['name' => 'Test McTestus', 'email' => 'test@mctest.us', 'id' => 1, 'message' => 'This is a test.', 'g-recaptcha-response' => 'alwayspass'];
        $this->post('/contact', $good)->assertResponseOk();
    }

    public function testCampCost()
    {
        $this->visit('/cost')->see('dorm style');
    }
}
