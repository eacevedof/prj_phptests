<?php
namespace App\Publishing\Domain\Ports;

use App\Publishing\Domain\UserEntity;

interface IUserRepository
{
    public function ofIdOrFail(int $id): UserEntity;

    public function save(UserEntity $userEntity): void;
}