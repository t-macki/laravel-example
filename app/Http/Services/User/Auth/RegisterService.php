<?php
namespace App\Services\User\Auth;

use App\Exceptions\ServiceException;
use Domain\Exceptions\DomainException;

/**
 * 会員登録
 */
class RegisterService
{
    /** @var \Domain\Services\User\UserRegister */
    private $userRegisterService;

    /**
     * RegisterService constructor.
     * @param \Domain\Services\User\UserRegister $userRegisterService
     */
    public function __construct(
        \Domain\Services\User\UserRegister $userRegisterService
    ) {
        $this->userRegisterService = $userRegisterService;
    }

    /**
     * 会員登録
     * @param array $inputs
     * @return \Domain\Entity\User
     * @throws ServiceException
     * @throws \Exception
     */
    public function register(array $inputs): \Domain\Entity\User
    {
        \DB::beginTransaction();
        try {
            $user = $this->userRegisterService->register($inputs);

            \Log::debug("RegisterService ---------------------");
            \Log::debug($user);

            $this->userRegisterService->send($user);

            \DB::commit();
        } catch (DomainException $e) {
            \DB::rollBack();
            \Log::debug($e);
            throw new ServiceException($e->getMessage());
        }
        return $user;
    }

    /**
     * トークン認証
     * @param string $token
     * @return \Domain\Entity\User
     * @throws ServiceException
     */
    public function verify(string $token): \Domain\Entity\User
    {
        if (!$token) {
            throw new ServiceException(trans('message.user_register_verify_token_not_error'));
        }

        try {
            $user = $this->userRegisterService->verify($token);
        } catch (DomainException $e) {
            \Log::debug($e);
            throw new ServiceException($e->getMessage());
        }

        try {
            $this->userRegisterService->doneSend($user);
        } catch (DomainException $e) {
            \Log::debug($e);
        }

        return $user;
    }
}
