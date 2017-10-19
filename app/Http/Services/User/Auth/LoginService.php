<?php
namespace App\Services\User\Auth;

use App\Exceptions\ServiceException;
use Domain\Exceptions\DomainException;

/**
 * 会員登録
 */
class LoginService
{
    /** @var \Domain\Services\User\UserSocialRegister */
    private $userRegisterService;

    /**
     * RegisterService constructor.
     * @param \Domain\Services\User\UserSocialRegister $userRegisterService
     */
    public function __construct(
        \Domain\Services\User\UserSocialRegister $userRegisterService
    ) {
        $this->userRegisterService = $userRegisterService;
    }

    /**
     * 会員登録
     * @param $facebook
     * @return \Domain\Entity\User
     * @throws ServiceException
     * @throws \Exception
     */
    public function register($facebook): \Domain\Entity\User
    {
        \DB::beginTransaction();
        try {
            $user = $this->userRegisterService->register($facebook);

            \Log::debug("RegisterService ---------------------");
            \Log::debug($user);

            \DB::commit();
        } catch (DomainException $e) {
            \DB::rollBack();
            \Log::debug($e);
            throw new ServiceException($e->getMessage());
        }
        return $user;
    }
}
