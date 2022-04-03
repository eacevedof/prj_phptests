<?php
namespace App\Publishing\Domain;

final class UserRepository
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