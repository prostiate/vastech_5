<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('vastechcloud@gmail.com')
            ->view('layouts.errors.mail.404')
            ->with(
                [
                    'nama' => 'Diki Alfarabi Hadi',
                    'website' => 'www.malasngoding.com',
                ]
            );
    }
}
