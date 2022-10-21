<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Teste extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA ElementarDev.');
        $this->to($this->data->contato->email, $this->data->contato->name);
        return $this->markdown('mail.AAAAAAAAAAAAAAAAAAAAAAAAA', [
            'data' => $this->data
        ]);
    }
}
