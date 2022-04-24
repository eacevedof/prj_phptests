<?php
namespace App\Blog\Domain\Bus\Event;

//https://youtu.be/uIu139WusKU?t=373
interface IDomainEventSubscriber
{
    public function onDomainEvent(IDomainEvent $domainEvent): self;
}