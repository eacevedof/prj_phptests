<?php
namespace App\Publishing\Domain;

final class UserRepository
{
    public function ofIdOrFail(int $id): UserEntity
    {
        return new UserEntity($id, "some@email.com");
    }
}