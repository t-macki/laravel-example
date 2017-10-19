<?php

namespace Domain\Services\Contact;

use App\Exceptions\ServiceException;
use Domain\Exceptions\DomainException;
use Domain\Interfaces\Notifications\ContactRegisterNotification;
use Domain\Interfaces\Repositories\ContactRepository;

/**
 * 会員登録
 */
class ContactRegister
{
    /** @var ContactRepository */
    private $repository;
    /** @var ContactRegisterNotification */
    private $notification;

    /**
     * ContactRegister constructor.
     * @param ContactRepository $contactRepository
     * @param ContactRegisterNotification $notification
     */
    public function __construct(
        ContactRepository $contactRepository,
        ContactRegisterNotification $notification
    ) {
        $this->repository = $contactRepository;
        $this->notification = $notification;
    }

    /**
     * 会員登録
     * @param array $inputs
     * @return \Domain\Entity\Contact
     * @throws ServiceException
     * @throws \Exception
     */
    public function register(array $inputs): \Domain\Entity\Contact
    {
        $contact = $this->repository->create($inputs);
        if (!$contact) {
            throw new DomainException(trans('message.user_register_error'));
        }
        return $contact->convertDomain();
    }

    public function send(\Domain\Entity\Contact $user)
    {
        \Log::debug("RegisterService send ---------------------");
        $this->notification->build($user);
    }
}
