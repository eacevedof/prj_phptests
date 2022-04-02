<?php
namespace App\Publishing\Domain;

final class UserEntity
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function publish()
    {

    }

    public function id(): int
    {
        return $this->id;
    }
}