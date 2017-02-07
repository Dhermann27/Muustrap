<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirm extends Mailable
{
    use Queueable, SerializesModels;
    public $year, $campers;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($year, $campers)
    {
        $this->year = $year;
        $this->campers = $campers;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('muusa@muusa.org')->text('mail.confirm');
    }
}
