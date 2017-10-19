<?php
namespace Domain\Interfaces\Notifications;

use Domain\Entity\User;

interface UserRegisterNotification
{
    public function build(User $user);
}