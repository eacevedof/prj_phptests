<?php
namespace App\Publishing\Domain;

/**
 * Rigor Talks - PHP - #20 - Application Services & Command Handlers (Spanish)
 * https://youtu.be/6dwrRVt2wVg
 * esta clase es un DTO que se podria serializar y logar
 */
final class PublishPostCommand implements IDto
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