<?php
namespace App\Publishing\Infrastructure\Repositories;

use App\Publishing\Domain\Ports\IPostRepository;
use App\Publishing\Domain\PostEntity;

final class PostRepository implements IPostRepository
{
    public function ofIdOrFail(int $id): PostEntity
    {
        return new PostEntity($id);
    }

    public function save(PostEntity $postEntity): void
    {
        echo "post saved ...<br/>";
    }
}