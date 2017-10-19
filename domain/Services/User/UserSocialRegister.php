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
class UserSocialRegister
{
    /** @var UserRepository */
    private $repository;

    /**
     * UserRegister constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->repository = $userRepository;
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
/*

User { ▼
  +token: ""
  +refreshToken: null
  +expiresIn: 1111
  +id: "1111"
  +nickname: null
  +name: "Test"
  +email: "test@gmail.com"
  +avatar: "aaaaa"
  +user: array:6 [▼
    "name" => "Test"
    "email" => "test@gmail.com"
    "gender" => "male"
    "verified" => true
    "link" => "test"
    "id" => "1111"
  ]
  +"avatar_original": "test"
  +"profileUrl": "test"
}
*/
        $inputs['name'] = $facebook->name;
        $inputs['email'] = $facebook->email;
        $inputs['password'] = bcrypt('11111111');
        $inputs['provider'] = 'facebook';
        $inputs['provider_id'] = $facebook->id;
        $inputs['status'] = \Config::get('const.USER_STATUS_REGIST');

        $user = $this->repository->first('email', $facebook->email);
        if (!$user) {
            $user = $this->repository->create($inputs);
            if (!$user) {
                throw new DomainException(trans('message.user_register_error'));
            }
        }
        return $user->convertDomain();
    }
}
