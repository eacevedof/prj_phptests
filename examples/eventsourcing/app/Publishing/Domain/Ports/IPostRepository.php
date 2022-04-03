<?php
namespace App\Publishing\Domain\Ports;

use App\Publishing\Domain\PostEntity;

interface IPostRepository
{
    public function ofIdOrFail(int $id): PostEntity;

    public function save(PostEntity $postEntity): void;
}