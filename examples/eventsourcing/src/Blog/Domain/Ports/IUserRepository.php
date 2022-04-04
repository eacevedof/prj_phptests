<?php
namespace App\Blog\Domain\Ports;

use App\Blog\Domain\UserEntity;

interface IUserRepository
{
    public function ofIdOrFail(int $id): UserEntity;

    public function save(UserEntity $userEntity): void;
}