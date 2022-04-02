<?php
namespace App\Publishing;

use App\Publishing\UserEntity;

final class UserRepository
{
    public function ofIdOrFail(int $id): UserEntity
    {
        return new UserEntity();
    }
}