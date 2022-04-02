<?php
namespace EventSourcing;

//https://youtu.be/uIu139WusKU?t=373
interface IDomainEventSubscriber
{
    public function isSubscribedTo(IDomainEvent $domainEvent): bool;

    public function handle(IDomainEvent $domainEvent): self;

}