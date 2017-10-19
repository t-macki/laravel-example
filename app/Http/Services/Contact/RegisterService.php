<?php
namespace App\Services\Contact;

use App\Exceptions\ServiceException;
use Domain\Exceptions\DomainException;

/**
 * 会員登録
 */
class RegisterService
{
    /** @var \Domain\Services\Contact\ContactRegister */
    private $contactRegisterService;

    /**
     * RegisterService constructor.
     * @param \Domain\Services\Contact\ContactRegister $contactRegisterService
     */
    public function __construct(
        \Domain\Services\Contact\ContactRegister $contactRegisterService
    ) {
        $this->contactRegisterService = $contactRegisterService;
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
        \DB::beginTransaction();
        try {
            $contact = $this->contactRegisterService->register($inputs);

            $this->contactRegisterService->send($contact);

            \DB::commit();
        } catch (DomainException $e) {
            \DB::rollBack();
            \Log::debug($e);
            throw new ServiceException($e->getMessage());
        }
        return $contact;
    }
}
