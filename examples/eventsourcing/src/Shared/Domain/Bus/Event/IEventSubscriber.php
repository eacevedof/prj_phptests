<?php
namespace App\Shared\Domain\Bus\Event;

//https://youtu.be/uIu139WusKU?t=373
interface IEventSubscriber
{
    public function onDomainEvent(IEvent $domainEvent): self;
}