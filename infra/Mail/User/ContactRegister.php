<?php

namespace Infra\Mail\User;

use Domain\Entity\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRegister extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Contact */
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        \Log::debug("ContactRegister Mailable build ---------------------");
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact.contact')->subject('お問い合わせ');
    }
}
