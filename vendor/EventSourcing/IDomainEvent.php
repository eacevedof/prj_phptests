<?php
namespace EventSourcing;

interface IDomainEvent
{
    public function occurredOn(): int;
}