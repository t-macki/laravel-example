<?php
namespace Domain\Entity;

/**
 * Created by PhpStorm.
 * User: makino
 * Date: 2017/10/13
 * Time: 17:05
 */
class User implements EntityInterface
{
    use EntityTrait;

    private $id;
    private $email;
    private $password;
    private $name;
    private $email_temp;
    private $email_before;
    private $email_withdrawal;
    private $status;
    private $provider;
    private $provider_id;
    private $email_verify_token;
    private $email_verify_time;
    private $email_verify_sent_at;
    private $email_verify_status;
    private $updated_at;
    private $created_at;
}
