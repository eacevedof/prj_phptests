<?php
namespace App\Blog\Application\Commands;

final class PublishCommand implements ICommand
{
    private int $postId;
    private int $authorId;

    public function __construct(int $postId, int $authorId)
    {
        $this->postId = $postId;
        $this->authorId = $authorId;
    }

    public function postId():int
    {
        return $this->postId;
    }

    public function authorId():int
    {
        return $this->authorId;
    }
}