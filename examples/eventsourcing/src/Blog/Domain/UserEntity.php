<?php
namespace App\Blog\Domain;

use App\Blog\Domain\Types\UserEmailType;
use App\Blog\Domain\Types\UserIdType;
use App\Shared\Domain\IEntity;

final class UserEntity implements IEntity
{
    private UserIdType $id;
    private UserEmailType $email;

    public function __construct(UserIdType $id, UserEmailType $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function id(): UserIdType
    {
        return $this->id;
    }

    public function email(): UserEmailType
    {
        return $this->email;
    }
}