<?php
namespace App\Blog\Domain\Ports;

use App\Blog\Domain\PostEntity;
use App\Blog\Domain\Types\PostIdType;

interface IPostRepository
{
    public function ofIdOrFail(PostIdType $id): PostEntity;

    public function save(PostEntity $postEntity): void;
}