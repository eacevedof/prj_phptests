<?php
namespace App\Blog\Domain\Ports;

use App\Blog\Domain\Types\UserIdType;
use App\Blog\Domain\UserEntity;

interface IUserRepository
{
    public function ofIdOrFail(UserIdType $id): UserEntity;

    public function save(UserEntity $userEntity): void;
}