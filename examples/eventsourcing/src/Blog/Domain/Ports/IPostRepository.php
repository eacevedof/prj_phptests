<?php
namespace App\Blog\Domain\Ports;

use App\Blog\Domain\PostEntity;

interface IPostRepository
{
    public function ofIdOrFail(int $id): PostEntity;

    public function save(PostEntity $postEntity): void;
}