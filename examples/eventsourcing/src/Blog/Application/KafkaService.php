<?php
namespace App\Blog\Application;

use App\Shared\Infrastructure\Kafka\Kafka;
use App\Shared\Domain\Bus\Event\IEvent;
use App\Shared\Domain\Bus\Event\IEventSubscriber;
use App\Blog\Domain\Events\PostWasPublishedEvent;

final class KafkaService implements IEventSubscriber
{
    private function sendOnPostPublished(IEvent $domainEvent): void
    {
        if (get_class($domainEvent)!==PostWasPublishedEvent::class) return;
        echo "kafkaing ...<br/>";
        (new Kafka())->produce(serialize($domainEvent));
    }

    public function onDomainEvent(IEvent $domainEvent): IEventSubscriber
    {
        $this->sendOnPostPublished($domainEvent);
        return $this;
    }
}