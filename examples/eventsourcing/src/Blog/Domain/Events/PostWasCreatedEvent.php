<?php
namespace App\Blog\Domain\Events;

use App\Blog\Domain\Bus\Event\IDomainEvent;
use \DateTimeImmutable;

final class PostWasCreatedEvent implements IDomainEvent
{
    private int $postId;
    private int $authorId;
    private int $occurredOn;

    public function __construct(int $postId, int $authorId)
    {
        $this->postId = $postId;
        $this->authorId = $authorId;
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