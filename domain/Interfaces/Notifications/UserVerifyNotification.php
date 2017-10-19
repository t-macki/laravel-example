<?php
namespace Domain\Interfaces\Notifications;

use Domain\Entity\User;

interface UserVerifyNotification
{
    public function build(User $user);
}