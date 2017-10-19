<?php
namespace Domain\Entity;

class Contact implements EntityInterface
{
    use EntityTrait;

    private $id;
    private $name;
    private $email;
    private $subject;
    private $content;
    private $updated_at;
    private $created_at;
}
