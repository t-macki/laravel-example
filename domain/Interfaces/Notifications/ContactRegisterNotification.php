<?php
namespace Domain\Interfaces\Notifications;

use Domain\Entity\Contact;

interface ContactRegisterNotification
{
    public function build(Contact $user);
}
