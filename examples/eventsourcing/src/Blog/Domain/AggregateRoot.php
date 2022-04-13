<?php
namespace App\Blog\Domain;

use EventSourcing\IDomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(IDomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}