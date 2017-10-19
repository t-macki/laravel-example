<?php

namespace Domain\Services\User;

use App\Exceptions\ServiceException;
use Domain\Exceptions\DomainException;
use Domain\Interfaces\Notifications\UserVerifyNotification;
use Domain\Services\Shared\DataService;
use Domain\Services\Shared\TokenService;
use Carbon\Carbon;
use Domain\Interfaces\Repositories\UserRepository;
use Domain\Interfaces\Notifications\UserRegisterNotification;

/**
 * 会員登録
 */
class UserRegister
{
    /** @var UserRepository */
    private $repository;
    /** @var UserRegisterNotification */
    private $notification;
    /** @var UserVerifyNotification */
    private $verifyNotification;

    /**
     * UserRegister constructor.
     * @param UserRepository $userRepository
     * @param UserRegisterNotification $userNotification
     * @param UserVerifyNotification $verifyNotification
     */
    public function __construct(
        UserRepository $userRepository,
        UserRegisterNotification $userNotification,
        UserVerifyNotification $verifyNotification
    ) {
        $this->repository = $userRepository;
        $this->notification = $userNotification;
        $this->verifyNotification = $verifyNotification;
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
        $inputs['email_verify_token'] = TokenService::makeEmailVerifyToken(
            \Config::get('app.key'),
            $inputs['email']
        );
        $inputs['email_verify_sent_at'] = Carbon::now();
        $inputs['email_verify_status'] = \Config::get('const.USER_VERIFY_STATUS_NG');

        $inputs['email_temp'] = $inputs['email'];
        $inputs['email'] = $inputs['email'] . '_temp';
        $inputs['password'] = bcrypt($inputs['password']);
        $inputs['status'] = \Config::get('const.USER_STATUS_NONE');

        $user = $this->repository->first('email_temp', $inputs['email_temp']);
        if ($user) {
            $user = $this->repository->update($inputs, $user->id);
            if (!$user) {
                throw new DomainException(trans('message.user_register_error'));
            }
        } else {
            $user = $this->repository->create($inputs);
            if (!$user) {
                throw new DomainException(trans('message.user_register_error'));
            }
        }
        return $user->convertDomain();
    }

    /**
     * メール認証
     * @param string $token
     * @return \Domain\Entity\User
     * @throws ServiceException
     */
    public function verify(string $token): \Domain\Entity\User
    {
        $model = $this->repository->first('email_verify_token', $token);
        if (!$model) {
            throw new DomainException(trans('message.user_register_verify_token_not_error'));
        }
        $user = $model->convertDomain();

        if (empty($user->email_verify_sent_at)) {
            throw new DomainException(trans('message.user_register_verify_sent_at_error'));
        }

        if (!DataService::checkDataMax($user->email_verify_sent_at, \Config::get('const.USER_VERIFY_DAY'))) {
            throw new DomainException(trans('message.user_register_verify_sent_at_error'));
        }

        $user = $this->repository->verifyDone($user->id);

        return $user->convertDomain();
    }


    /**
     * 会員登録
     * @param array $inputs
     * @throws ServiceException
     * @throws \Exception
     */
    public function send(\Domain\Entity\User $user)
    {
        \Log::debug("RegisterService send ---------------------");
        $this->notification->build($user);
    }

    public function doneSend(\Domain\Entity\User $user)
    {
        $this->verifyNotification->build($user);
    }
}
