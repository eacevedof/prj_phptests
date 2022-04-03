<?php
namespace App\Publishing\Domain;

final class PostRepository
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