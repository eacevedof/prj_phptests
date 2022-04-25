<?php
namespace App\Blog\Infrastructure\Repositories;

use App\Blog\Domain\Ports\IUserRepository;
use App\Blog\Domain\Types\UserEmailType;
use App\Blog\Domain\Types\UserIdType;
use App\Blog\Domain\UserEntity;

final class UserRepository implements IUserRepository
{
    public function ofIdOrFail(UserIdType $id): UserEntity
    {
        return new UserEntity($id, new UserEmailType("some@email.com"));
    }

    public function save(UserEntity $userEntity): void
    {
        echo "user saved ...<br/>";
    }
}