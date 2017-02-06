<?php

class MuusaTest extends TestCase
{
    public function testHomepage()
    {
        $this->visit('/')->see('MUUSA');
    }

    public function testContactUs()
    {
        $this->get('/contact')->see('Technical Support');
    }

    public function testSendContactUs()
    {
        Session::start();
        $good = ['name' => 'Test McTestus', 'email' => 'test@mctest.us', 'id' => 1, 'message' => 'This is a test.',
            'g-recaptcha-response' => 'alwayspass', '_token' => csrf_token()];
        $this->post('/contact', $good)->see('Message sent');
    }

    public function testCampCost()
    {
        $this->visit('/cost')->see('dorm style');
    }
}
