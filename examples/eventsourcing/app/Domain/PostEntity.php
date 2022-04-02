<?php
namespace App\Publishing\Domain;

final class PostEntity
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function publish()
    {

    }
}