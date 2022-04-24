<?php
namespace App\Blog\Domain\Aggregate;

use App\Shared\Domain\Bus\Event\IEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(IEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}