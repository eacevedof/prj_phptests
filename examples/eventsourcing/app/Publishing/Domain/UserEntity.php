<?php
namespace App\Publishing\Domain;

final class UserEntity implements IEntity
{
    private int $id;
    private string $email;

    public function __construct(int $id)
    {
        $this->id = $id;
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