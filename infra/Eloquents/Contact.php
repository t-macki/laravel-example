<?php
namespace Infra\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'id',
        'name',
        'email',
        'subject',
        'content',
        'updated_at',
        'created_at',
    ];

    public function convertDomain(): \Domain\Entity\Contact
    {
        \Log::debug("convdrtDomain --------------------- ");
        \Log::debug($this->toArray());
        return new \Domain\Entity\Contact($this->toArray());
    }
}