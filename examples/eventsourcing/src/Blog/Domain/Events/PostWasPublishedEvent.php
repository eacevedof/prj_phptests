<?php
namespace App\Blog\Domain\Events;

use EventSourcing\IDomainEvent;
use \DateTimeImmutable;

final class PostWasPublishedEvent implements IDomainEvent
{
    private int $postId;
    private int $authorId;
    private int $occurredOn;

    //https://youtu.be/qwPFZ9v91kw?t=2112
    private string $messageId;
    private string $causationId;
    private string $correlationId;

    public function __construct(int $postId, int $authorId)
    {
        $this->postId = $postId;
        $this->authorId = $authorId;
        $this->messageId = uniqid();
        $this->causationId = "1";
        $this->correlationId = "1";
        $this->occurredOn = (new DateTimeImmutable())->getTimestamp();
    }

    public function occurredOn(): int
    {
        return $this->occurredOn;
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