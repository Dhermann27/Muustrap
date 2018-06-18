<?php

namespace App\Mail;

use App\Thisyear_Camper;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArtFair extends Mailable
{
    use Queueable, SerializesModels;
    public $request;
    public $camper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request, Thisyear_Camper $camper)
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
        $view = $this->from($this->camper->email)->replyTo($this->camper->email)->view('mail.artfair');
        if (count($this->request->images) > 0) {
            foreach ($this->request->images as $index => $image) {
                $view->attach($image, [
                    'as' => $this->camper->lastname . $index . "." . $image->extension(),
                    'mime' => $image->getMimeType(),
                ]);
            }
        }
        return $view;
    }
}
