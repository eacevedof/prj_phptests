<?php
namespace App\Blog\Application;

use App\Blog\Infrastructure\Kafka;
use EventSourcing\IDomainEvent;
use EventSourcing\IDomainEventSubscriber;
use App\Blog\Domain\Events\PostWasPublishedEvent;

final class KafkaService implements IDomainEventSubscriber
{
    private function sendOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;
        echo "Kafkaing ...";
        (new Kafka())->produce(serialize($domainEvent));
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->sendOnPostPublished($domainEvent);
        return $this;
    }
}