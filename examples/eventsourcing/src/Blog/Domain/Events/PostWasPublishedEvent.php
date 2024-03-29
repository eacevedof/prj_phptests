<?php
namespace App\Blog\Domain\Events;

use App\Shared\Domain\Bus\Event\IEvent;
use \DateTimeImmutable;

//https://github.com/CodelyTV/php-ddd-example/blob/main/src/Mooc/Videos/Domain/VideoCreatedDomainEvent.php
final class PostWasPublishedEvent implements IEvent
{
    private int $postId;
    private int $authorId;
    private int $occurredOn;

    //standard MQP usando ZIPKIN o JAGGER
    //https://youtu.be/qwPFZ9v91kw?t=2112
    private string $messageId;
    //bigbang id
    private string $correlationId;
    // parent id
    private string $causationId;

    public function __construct(int $postId, int $authorId)
    {
        $this->messageId = uniqid();
        $this->correlationId = "1";
        $this->causationId = "1";

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

    public function messageId(): string
    {
        return $this->messageId;
    }

    public function correlationId(): string
    {
        return $this->correlationId;
    }

    public function causationId(): string
    {
        return $this->causationId;
    }
}