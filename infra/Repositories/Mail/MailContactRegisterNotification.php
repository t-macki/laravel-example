<?php

namespace Infra\Repositories\Mail;

use Domain\Entity\Contact;
use Domain\Interfaces\Notifications\ContactRegisterNotification;
use Infra\Exceptions\InfraException;

class MailContactRegisterNotification implements ContactRegisterNotification
{
    /**
     * @param array $user
     * @throws InfraException
     */
    public function build(Contact $contact)
    {
        \Log::debug("MailContactRegisterNotification build ---------------------");
        \Log::debug(print_r($contact, true));
        try {
            \Mail::to($contact->email)->send(new \Infra\Mail\User\ContactRegister($contact));
        } catch (\Exception $e) {
            \Log::debug($e);
            throw new InfraException(trans('message.user_register_mail_error'));
        }
    }
}
