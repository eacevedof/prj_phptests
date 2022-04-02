<?php
namespace App\Publishing\Domain;

/**
 * https://youtu.be/6dwrRVt2wVg
 * esta clase es un DTO que se podria serializar y logar
 * Class PublishPostCommand
 * @package App\Publishing\Domain
 */
final class PublishPostCommand
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