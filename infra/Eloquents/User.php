<?php

namespace Infra\Eloquents;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Infra\Mail\User\PasswordReset;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'email_temp',
        'email_before',
        'email_withdrawal',
        'status',
        'email_verify_token',
        'email_verify_time',
        'email_verify_sent_at',
        'email_verify_status',
        'updated_at',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function convertDomain(): \Domain\Entity\User
    {
        \Log::debug("convdrtDomain --------------------- ");
        \Log::debug($this->toArray());
        return new \Domain\Entity\User($this->toArray());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
}
