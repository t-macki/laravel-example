<?php

namespace Infra\Mail\User;

use Domain\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserVerify extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        \Log::debug(print_r($user, true));
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user.auth.verify')->subject('登録完了');
    }
}
