<?php

namespace App\Mail;

use App\Camper;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Proposal extends Mailable
{
    use Queueable, SerializesModels;
    public $request;
    public $camper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request, Camper $camper)
    {
        $this->request = $request;
        $this->camper = $camper;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = $this->from($this->camper->email)->cc($this->camper->email)->view('mail.proposal');
    }
}
