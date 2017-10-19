<?php

namespace Infra\Repositories\Mail;

use Domain\Entity\User;
use Domain\Interfaces\Notifications\UserRegisterNotification;
use Infra\Exceptions\InfraException;

class MailUserRegisterNotification implements UserRegisterNotification
{
    /**
     * @param array $user
     * @throws InfraException
     */
    public function build(User $user){
        \Log::debug("MailUserRegisterNotification build ---------------------");
        \Log::debug(print_r($user, true));
        try {
            \Mail::to($user->email_temp)->send(new \Infra\Mail\User\UserRegister($user));
        } catch (\Exception $e) {
            \Log::debug($e);
            throw new InfraException(trans('message.user_register_mail_error'));
        }
    }
}