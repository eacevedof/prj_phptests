<?php
namespace App\Blog\Application;

use App\Blog\Infrastructure\Kafka;
use App\Blog\Domain\Bus\Event\IDomainEvent;
use App\Blog\Domain\Bus\Event\IDomainEventSubscriber;
use App\Blog\Domain\Events\PostWasPublishedEvent;

final class KafkaService implements IDomainEventSubscriber
{
    private function sendOnPostPublished(IDomainEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;
        echo "kafkaing ...<br/>";
        (new Kafka())->produce(serialize($domainEvent));
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        $this->sendOnPostPublished($domainEvent);
        return $this;
    }
}