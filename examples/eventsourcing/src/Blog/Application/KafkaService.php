<?php
namespace App\Blog\Application;

use App\Blog\Infrastructure\Kafka;
use EventSourcing\IDomainEvent;
use EventSourcing\IDomainEventSubscriber;
use App\Blog\Domain\Events\PostWasPublishedEvent;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;

final class KafkaService implements IDomainEventSubscriber
{
    private function logOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;

        $emailTo = (new UserRepository())->ofIdOrFail($domainEvent->authorId())->email();
        $title = (new PostRepository())->ofIdOrFail($domainEvent->postId())->title();
        echo "Kafkaging ...";
        (new Kafka())->log("Post with title {$title} published by user {$emailTo}");
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->logOnPostPublished($domainEvent);
        return $this;
    }
}