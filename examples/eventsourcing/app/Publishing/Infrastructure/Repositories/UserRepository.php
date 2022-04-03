<?php
namespace App\Publishing\Infrastructure\Repositories;

use App\Publishing\Domain\Ports\IUserRepository;
use App\Publishing\Domain\UserEntity;

final class UserRepository implements IUserRepository
{
    public function ofIdOrFail(int $id): UserEntity
    {
        return new UserEntity($id, "some@email.com");
    }

    public function save(UserEntity $userEntity): void
    {
        echo "user saved ...<br/>";
    }
}