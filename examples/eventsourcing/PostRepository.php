<?php


final class PostRepository
{
    public function ofIdOrFail(int $id): PostEntity
    {
        return new PostEntity();
    }
}