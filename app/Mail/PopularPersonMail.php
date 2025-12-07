<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PopularPersonMail extends Mailable
{
    use Queueable, SerializesModels;

    public $personId;
    public $personName;
    public $likes;

    public function __construct($personId, $personName, $likes)
    {
        $this->personId = $personId;
        $this->personName = $personName;
        $this->likes = $likes;
    }

    public function build()
    {
        return $this->subject("Popular Person Alert: {$this->personName}")
                    ->markdown('emails.popular_person')
                    ->with([
                        'personId' => $this->personId,
                        'personName' => $this->personName, 
                        'likes' => $this->likes,
                    ]);
    }
}
