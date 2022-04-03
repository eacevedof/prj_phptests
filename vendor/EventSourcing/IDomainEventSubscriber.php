<?php
namespace EventSourcing;

//https://youtu.be/uIu139WusKU?t=373
interface IDomainEventSubscriber
{
    public function onEvent(IDomainEvent $domainEvent): self;
}