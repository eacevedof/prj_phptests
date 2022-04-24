<?php
namespace App\Blog\Domain;

use App\Shared\Domain\IEntity;

final class UserEntity implements IEntity
{
    private int $id;
    private string $email;

    public function __construct(int $id, string $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }
}