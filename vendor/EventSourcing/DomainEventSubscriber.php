<?php
namespace EventSourcing;

final class DomainEventSubscriber
{
    public function isSubscribedTo(IDomainEvent $domainEvent): bool
    {
        return false;
    }

    public function handle(): self
    {
        return $this;
    }
}