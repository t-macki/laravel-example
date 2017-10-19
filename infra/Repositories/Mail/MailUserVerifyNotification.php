<?php

namespace Infra\Repositories\Mail;

use Domain\Entity\User;
use Domain\Interfaces\Notifications\UserVerifyNotification;
use Infra\Exceptions\InfraException;

class MailUserVerifyNotification implements UserVerifyNotification
{
    /**
     * @param array $user
     * @throws InfraException
     */
    public function build(User $user){
        try {
            \Mail::to($user->email)->send(new \Infra\Mail\User\UserVerify($user));
        } catch (\Exception $e) {
            \Log::debug($e);
            throw new InfraException(trans('message.user_register_mail_error'));
        }
    }
}