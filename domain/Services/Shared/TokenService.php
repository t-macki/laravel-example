<?php
namespace Domain\Services\Shared;

class TokenService
{
    /**
     * トークン生成
     * @param $key
     * @param $mail
     * @return string
     */
    public static function makeEmailVerifyToken($key, $mail)
    {
        return hash_hmac(
            'sha256',
            str_random(40) . $mail,
            $key
        );
    }
}
